<?php
// app/Http/Controllers/Guru/HomeController.php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Carbon\Carbon;

class HomeController extends Controller
{
  public function index()
  {
    $today = Carbon::today();   // 2025-05-25

    $presentCount = Absensi::whereDate('tgl_waktu_absen', $today)->where('status_absen', 'hadir')->count();

    $sickCount = Absensi::whereDate('tgl_waktu_absen', $today)->where('status_absen', 'sakit')->count();

    $permissionCount = Absensi::whereDate('tgl_waktu_absen', $today)->where('status_absen', 'izin')->count();

    $absentCount = Absensi::whereDate('tgl_waktu_absen', $today)->where('status_absen', 'alpha')->count();

    return view('guru.home.index', compact('presentCount', 'sickCount', 'permissionCount', 'absentCount'));
  }
}
