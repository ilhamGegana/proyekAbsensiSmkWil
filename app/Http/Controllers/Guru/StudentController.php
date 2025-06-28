<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\{Siswa, Absensi, JadwalPelajaran};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Jobs\SendNotifikasiAlpha;
use App\Models\Notifikasi;

class StudentController extends Controller
{
    /* ===============================================================
     |  Ambil seluruh jadwal AKTIF milik guru
     |=============================================================== */
    protected function schedules(int $guruId, string $hari)
    {
        return JadwalPelajaran::aktif()
            ->with('kelas:id,nama_kelas', 'mapel:id,nama_mapel')
            ->where('id_guru', $guruId)
            ->where('hari', $hari)          // ← filter nama hari
            ->orderBy('jam_ke')
            ->get();
    }

    /* ===============================================================
     |  INDEX  – daftar siswa + status absensi tanggal tertentu
     |=============================================================== */
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;
        $date = $request->input('date', Carbon::today()->toDateString());
        $hari = Carbon::parse($date)->isoFormat('dddd');   // “Senin”, …, “Minggu”

        /* ─── jadwal aktif guru di hari tsb ─── */
        $schedules = $this->schedules($guru->id, $hari);

        // ⇢ ①  kalau kosong --> kirim view kosong,
        //     JANGAN abort 403
        if ($schedules->isEmpty()) {
            return view('guru.student.index', [
                'students'           => collect(),
                'schedules'          => collect(),   // dropdown jadwal akan hilang
                'selectedScheduleId' => null,
                'date'               => $date,
                'hari'               => $hari,      // utk pesan di blade (optional)
            ]);
        }

        /* ─── pilih jadwal ─── */
        $selectedScheduleId = $request->input('jadwal', $schedules->first()->id);
        $selectedSchedule   = $schedules->firstWhere('id', $selectedScheduleId);
        abort_unless($selectedSchedule !== null, 403, 'Jadwal tidak ditemukan.');

        /* ─── siswa & absensi ─── */
        $query = Siswa::with([
            'kelas:id,nama_kelas',
            'absensi' => fn($q) =>
            $q->where('id_jadwal', $selectedScheduleId)
                ->whereDate('tgl_waktu_absen', $date)
        ])->where('id_kelas', $selectedSchedule->id_kelas);

        if ($request->filled('name')) {
            $query->where('nama_siswa', 'like', '%' . $request->name . '%');
        }

        return view('guru.student.index', [
            'students'           => $query->get(),
            'schedules'          => $schedules,
            'selectedScheduleId' => $selectedScheduleId,
            'date'               => $date,
            'hari'               => $hari,
        ]);
    }

    /* ===============================================================
     |  Guard: pastikan siswa benar-benar di kelas jadwal & jadwal aktif
     |=============================================================== */
    protected function ensureInSchedule(Siswa $siswa, int $jadwalId): JadwalPelajaran
    {
        $guru  = Auth::user()->guru;

        $jadwal = JadwalPelajaran::aktif()            // ← hanya jadwal aktif
            ->where('id', $jadwalId)
            ->where('id_guru', $guru->id)
            ->firstOrFail();                          // 404 jika tidak ditemukan / non-aktif

        abort_unless(
            $siswa->id_kelas == $jadwal->id_kelas,
            403,
            'Siswa bukan di kelas jadwal ini.'
        );

        return $jadwal;
    }

    /* ===============================================================
     |  FORM EDIT STATUS ABSENSI
     |=============================================================== */
    public function edit(Request $request, Siswa $siswa)
    {
        $jadwalId = $request->input('jadwal');
        $date     = $request->input('date', Carbon::today()->toDateString());

        $this->ensureInSchedule($siswa, $jadwalId);

        $absensi = Absensi::firstOrCreate(
            [
                'id_siswa'        => $siswa->id,
                'id_jadwal'       => $jadwalId,
                'tgl_waktu_absen' => $date,
            ],
            ['status_absen' => 'alpha']
        );

        return view('guru.student.edit', compact('siswa', 'absensi', 'date', 'jadwalId'));
    }

    /* ===============================================================
     |  SIMPAN STATUS ABSENSI & NOTIF ALPHA
     |=============================================================== */
    public function update(Request $request, Siswa $siswa)
    {
        $jadwalId = $request->input('jadwal');
        $date     = $request->input('date', Carbon::today()->toDateString());

        $this->ensureInSchedule($siswa, $jadwalId);

        $data = $request->validate([
            'status_absen' => 'required|in:hadir,sakit,izin,alpha',
            'keterangan'   => 'nullable|string|max:255',
        ]);

        Absensi::updateOrCreate(
            [
                'id_siswa'        => $siswa->id,
                'id_jadwal'       => $jadwalId,
                'tgl_waktu_absen' => $date,
            ],
            $data
        );

        /* kirim notifikasi bila alpha */
        if ($data['status_absen'] === 'alpha') {

            $walikelas = $siswa->kelas?->guru;

            if ($walikelas && $walikelas->telpon_guru) {
                $notif = Notifikasi::create([
                    'id_guru'      => $walikelas->id,
                    'id_siswa'     => $siswa->id,
                    'pesan'        => "Anak Anda {$siswa->nama_siswa} Alpha/Tidak Masuk",
                    'tujuan'       => $walikelas->telpon_guru,
                    'status_kirim' => 'pending',
                ]);

                dispatch(new SendNotifikasiAlpha($notif));
            }
        }

        return redirect()->route('guru.students.index', [
            'jadwal' => $jadwalId,
            'date'   => $date,
        ])->with('success', 'Status absensi berhasil diperbarui.');
    }
}
