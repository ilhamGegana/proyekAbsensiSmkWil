<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Absensi, JadwalPelajaran, Siswa};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\PerceptualHash;
use App\Models\SignatureSetting;
use App\Traits\HandlesAbsensi;
use Intervention\Image\Laravel\Facades\Image;

class AttendanceController extends Controller
{
    /* ================================================================
     |  HALAMAN DAFTAR ABSENSI (pilih jadwal, lihat siswa & status)
     |================================================================ */
    use HandlesAbsensi;
    protected ImageHash $hasher;
    protected int $threshold;
    public function __construct()
    {
        // Inisialisasi pHash
        $this->hasher = new ImageHash(new PerceptualHash());
        $this->threshold = SignatureSetting::first()->threshold ?? 75;
    }
    public function index(Request $request)
    {
        $guru   = Auth::user()->guru;          // guru yang login
        $today  = Carbon::today();             // 2025-06-28, dst.
        $hari   = $today->isoFormat('dddd');   // "Sabtu", "Senin", …

        /* ─── jadwal aktif guru untuk hari ini ─── */
        $schedules = JadwalPelajaran::aktif()
            ->with('kelas:id,nama_kelas', 'mapel:id,nama_mapel')
            ->where('id_guru', $guru->id)
            ->where('hari',   $hari)
            ->orderBy('jam_ke')
            ->get();

        // guru tidak mengajar hari ini
        if ($schedules->isEmpty()) {
            return view('guru.attendance.index', [
                'students'           => collect(),
                'absensiMap'         => [],
                'schedules'          => collect(),
                'selectedScheduleId' => null,
                'today'              => $today,
            ]);
        }

        /* ─── jadwal terpilih (default = pertama) ─── */
        $selectedScheduleId = $request->input('jadwal', $schedules->first()->id);
        $selectedSchedule   = $schedules->firstWhere('id', $selectedScheduleId);

        if (! $selectedSchedule) {
            return back()->with('warning', 'Jadwal tidak ditemukan.');
        }

        /* ─── siswa & absensi ─── */
        $students = Siswa::with('kelas:id,nama_kelas')
            ->where('id_kelas', $selectedSchedule->id_kelas)
            ->orderBy('nama_siswa')
            ->get();

        $absensiMap = Absensi::where('id_jadwal', $selectedScheduleId)
            ->whereDate('tgl_waktu_absen', $today)
            ->get()
            ->keyBy('id_siswa');

        return view('guru.attendance.index', compact(
            'students',
            'absensiMap',
            'schedules',
            'selectedScheduleId',
            'today'
        ));
    }

    /* ================================================================
     |  FORM TANDA TANGAN (guru → siswa)
     |================================================================ */
    public function signForm(Request $request, Siswa $siswa)
    {
        $request->validate([
            'jadwal' => ['required', Rule::exists('jadwal_pelajaran', 'id')],
            'date'   => ['nullable', 'date'],
        ]);

        $jadwalId = $request->input('jadwal');
        $date     = $request->input('date', Carbon::today()->toDateString());

        // pastikan jadwal masih aktif & siswa di kelas tsb.
        $jadwal = JadwalPelajaran::aktif()->findOrFail($jadwalId);

        // CUKUP ambil absensi kalau sudah ada;
        $absensi = Absensi::where('id_siswa',  $siswa->id)
            ->where('id_jadwal', $jadwalId)
            ->whereDate('tgl_waktu_absen', $date)
            ->first();

        return view(
            'guru.attendance.sign',
            compact('siswa', 'absensi', 'jadwalId', 'date')
        );
    }

    /* ================================================================
     |  SIMPAN TANDA TANGAN
     |================================================================ */
    public function signStore(Request $request, Siswa $siswa)
    {
        $request->validate([
            'signature' => 'required|string',            // data URI base64
            'jadwal'    => ['required', Rule::exists('jadwal_pelajaran', 'id')],
            'date'      => ['nullable', 'date'],
        ]);

        $jadwalId = $request->input('jadwal');
        $date     = $request->input('date', Carbon::today()->toDateString());
        $newSig   = str_replace(' ', '+', $request->signature);
        $refSig   = $siswa->signature_data;             // data:image/png;base64,…

        // 1) Pastikan sudah ada signature referensi di akun siswa
        if (! $refSig) {
            return back()
                ->with('warning', 'Mohon daftarkan tanda tangan di akun siswa terlebih dahulu.')
                ->withInput();
        }

        // 2) Hitung similarity pHash
        try {
            $similarity = $this->compareSignatures($refSig, $newSig);
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'Gagal memproses tanda tangan: ' . $e->getMessage())
                ->withInput();
        }

        // 3) Cek threshold
        if ($similarity < $this->threshold) {
            return back()
                ->with('warning', "Tanda tangan kurang cocok ({$similarity}%). Silakan ulangi.")
                ->withInput();
        }

        /* 4) Simpan / perbarui absensi */
        $this->saveAbsensi(
            $siswa->id,
            $jadwalId,
            [
                'status_absen'  => 'hadir',
                'signature_ref' => $newSig,
            ]                                   // targetDate biarkan null ⇒ hari ini
        );

        return redirect()
            ->route('guru.attendance', ['jadwal' => $jadwalId])
            ->with('success', "Tanda tangan cocok ({$similarity} %). Absensi tersimpan.");
    }

    /**
     * Bandingkan dua data-URI base64 PNG menggunakan pHash.
     * @return float similarity dalam persen (2 desimal)
     */
    private function compareSignatures(string $base64_1, string $base64_2): float
    {
        // Buat dua file sementara
        $tmp1 = tempnam(sys_get_temp_dir(), 'sig1_');
        $tmp2 = tempnam(sys_get_temp_dir(), 'sig2_');

        // Decode base64 (buang prefix jika ada)
        [$b1, $b2] = array_map(fn($data) => base64_decode(
            str_contains($data, ',') ? explode(',', $data, 2)[1] : $data
        ), [$base64_1, $base64_2]);

        file_put_contents($tmp1, $b1);
        file_put_contents($tmp2, $b2);

        // Hitung Hamming distance & konversi ke persen similarity
        $distance   = $this->hasher->compare($tmp1, $tmp2);
        $similarity = 100 - ($distance / 64 * 100);

        // Bersihkan tmp files
        @unlink($tmp1);
        @unlink($tmp2);

        return round($similarity, 2);
    }
}
