<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
      'signature' => 'required|string' // base64 dataURL
    ]);

    $jadwalId = $request->input('jadwal');
    $date     = $request->input('date', Carbon::today()->toDateString());

    // simpan PNG di public/signatures
    $data      = $request->signature;
    [$meta, $content] = explode(',', $data);  // "data:image/png;base64,..."
    $pngData   = base64_decode($content);
    $filename  = 'sig_' . $siswa->id . '_' . now()->timestamp . '.png';
    $path      = public_path('signatures/' . $filename);
    file_put_contents($path, $pngData);

    // update absensi
    Absensi::updateOrCreate(
      ['id_siswa' => $siswa->id, 'id_jadwal' => $jadwalId, 'tgl_waktu_absen' => $date],
      ['signature_ref' => $filename]
    );

    return redirect()->route('guru.attendance', ['jadwal' => $jadwalId])
      ->with('success', 'Tanda tangan tersimpan.');
  }
}
