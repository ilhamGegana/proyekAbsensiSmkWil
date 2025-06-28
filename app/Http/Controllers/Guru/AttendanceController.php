<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Absensi, JadwalPelajaran, Siswa};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class AttendanceController extends Controller
{
    /* ================================================================
     |  HALAMAN DAFTAR ABSENSI (pilih jadwal, lihat siswa & status)
     |================================================================ */
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
        $absensi = Absensi::where([
            'id_siswa'        => $siswa->id,
            'id_jadwal'       => $jadwalId,
            'tgl_waktu_absen' => $date,
        ])->first();

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
            'signature' => 'required|string',          // base64
            'jadwal'    => ['required', Rule::exists('jadwal_pelajaran', 'id')],
            'date'      => ['nullable', 'date'],
        ]);

        $jadwalId = $request->input('jadwal');
        $date     = $request->input('date', Carbon::today()->toDateString());

        /* ---------- 1. Decode tanda tangan baru ---------- */
        $dataUri  = str_replace(' ', '+', $request->signature);
        $img      = Image::read($dataUri)->trim()->resizeCanvas(600, 200, 'ffffff', 'center');
        $filename = 'sig_' . $siswa->id . '_' . now()->timestamp . '.png';
        $pathNew  = public_path("signatures/{$filename}");
        $img->save($pathNew);

        /* ---------- 2. Cek keberadaan tanda tangan referensi ---------- */
        $pathRef = $siswa->signature_data ? public_path($siswa->signature_data) : null;

        if (! $pathRef || ! File::exists($pathRef)) {
            // hapus file baru agar tidak menumpuk
            File::delete($pathNew);

            return back()
                ->with('warning', 'Mohon tanda tangan dahulu di akun siswa.')
                ->withInput();
        }

        /* ---------- 3. Bandingkan dengan referensi ---------- */
        $proc    = Process::run([
            'python3',
            base_path('scripts/compare_sig.py'),
            $pathRef,
            $pathNew,
        ]);
        $isMatch = $proc->successful();

        if (! $isMatch) {
            File::delete($pathNew);
            return back()
                ->with('warning', 'Tanda tangan kurang cocok, silakan ulangi.')
                ->withInput();
        }

        /* ---------- 4. Simpan / perbarui record absensi ---------- */
        Absensi::updateOrCreate(
            [
                'id_siswa'        => $siswa->id,
                'id_jadwal'       => $jadwalId,
                'tgl_waktu_absen' => $date,
            ],
            [
                'status_absen'  => 'hadir',      // ← sekarang baru di-set hadir
                'signature_ref' => $filename,
            ]
        );

        return redirect()
            ->route('guru.attendance', ['jadwal' => $jadwalId])
            ->with('success', 'Tanda tangan tersimpan.');
    }
}
