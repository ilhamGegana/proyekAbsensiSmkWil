<?php

namespace App\Http\Controllers\Guru;

use Intervention\Image\Laravel\Facades\Image;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\File;


class AttendanceController extends Controller
{
  public function index(Request $request)
  {
    $guru   = Auth::user()->guru;               // guru yang login
    $today  = Carbon::today();

    // semua jadwal guru
    $schedules = JadwalPelajaran::with('kelas:id,nama_kelas', 'mapel:id,nama_mapel')
      ->where('id_guru', $guru->id)->get();

    if ($schedules->isEmpty()) {
      return view('guru.attendance.index', [
        'students'          => collect(),
        'absensiMap'        => [],
        'schedules'         => collect(),
        'selectedScheduleId' => null,
        'today'             => $today,
      ]);
    }

    // jadwal terpilih
    $selectedScheduleId = $request->input('jadwal', $schedules->first()->id);
    $selectedSchedule   = $schedules->firstWhere('id', $selectedScheduleId);

    // --- siswa dari kelas jadwal ---
    $students = \App\Models\Siswa::with('kelas:id,nama_kelas')
      ->where('id_kelas', $selectedSchedule->id_kelas)
      ->orderBy('nama_siswa')
      ->get();

    // --- ambil absensi existing (keyed by id_siswa) ---
    $absensiMap = Absensi::where('id_jadwal', $selectedScheduleId)
      ->whereDate('tgl_waktu_absen', $today)
      ->get()
      ->keyBy('id_siswa');     // → [id_siswa => Absensi]

    return view('guru.attendance.index', compact(
      'students',
      'absensiMap',
      'schedules',
      'selectedScheduleId',
      'today'
    ));
  }

  public function signForm(Request $request, \App\Models\Siswa $siswa)
  {
    $jadwalId = $request->input('jadwal');
    $date     = $request->input('date', Carbon::today()->toDateString());

    $absensi = Absensi::firstOrCreate(
      ['id_siswa' => $siswa->id, 'id_jadwal' => $jadwalId, 'tgl_waktu_absen' => $date],
      ['status_absen' => 'hadir']   // default status
    );

    return view('guru.attendance.sign', compact('siswa', 'absensi', 'jadwalId', 'date'));
  }

  public function signStore(Request $request, \App\Models\Siswa $siswa)
  {
    $request->validate([
      'signature' => 'required|string'      // base64
    ]);

    $jadwalId = $request->input('jadwal');
    $date     = $request->input('date', Carbon::today()->toDateString());

    /* ──────────────────────────
       1) baca Data-URI langsung
    ──────────────────────────*/
    $dataUri = str_replace(' ', '+', $request->signature);

    $img = Image::read($dataUri)
      ->trim()                        // buang tepi transparan
      ->resizeCanvas(                 // v3: 4 argumen
        600,                       // width
        200,                       // height
        'ffffff',                  // anchor
        'center'                   // bg putih
      );

    /* ──────────────────────────
       2) simpan
    ──────────────────────────*/
    $filename = 'sig_' . $siswa->id . '_' . now()->timestamp . '.png';
    $pathNew  = public_path("signatures/{$filename}");   // ← simpan ke variabel
    $img->save($pathNew);

    /* 2) ── skor kemiripan via Python ─────────────────────────── */
    $score = 1.0;         // default = cocok
    $pathRef = $siswa->signature_data
      ? public_path($siswa->signature_data)   // ← FIXED
      : null;

    if ($pathRef && File::exists($pathRef)) {
      $proc = Process::run([
        'python3',
        base_path('scripts/compare_sig.py'),
        $pathRef,
        $pathNew,
      ]);

      $isMatch = $proc->successful();   // exit 0 = MATCH
    }

    /* 3) ── validasi threshold (0.82 ≈ 82 %) ─────────────────── */
    if (! $isMatch) {
      File::delete($pathNew);
      return back()
        ->with('warning', 'Tanda tangan kurang cocok, silakan ulangi.')
        ->withInput();
    }
    /* ──────────────────────────
       3) update DB
    ──────────────────────────*/
    Absensi::updateOrCreate(
      [
        'id_siswa'        => $siswa->id,
        'id_jadwal'       => $request->jadwal,
        'tgl_waktu_absen' => $request->date ?? today(),
      ],
      ['signature_ref' => $filename]
    );

    return redirect()->route('guru.attendance', ['jadwal' => $jadwalId])
      ->with('success', 'Tanda tangan tersimpan.');
  }
}
