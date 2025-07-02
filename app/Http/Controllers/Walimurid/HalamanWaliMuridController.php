<?php

namespace App\Http\Controllers\Walimurid;

use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonInterface;

class HalamanWaliMuridController extends Controller
{
    public function index()
    {
        return view('walimurid.home.index');
    }

    public function history(Request $request)
    {
        $wali = Auth::user()->walimurid;
        $childs = $wali->siswa()->with('kelas')->get();

        $from  = $request->input('from');
        $to    = $request->input('to');
        $week  = $request->input('week');

        // Jika minggu ke-N dipilih, override tanggal from dan to
        if ($week) {
            $now = now();
            $startOfMonth = $now->copy()->startOfMonth();
            $startDate = $startOfMonth->copy()->addWeeks($week - 1)->startOfWeek(CarbonInterface::MONDAY);
            $endDate   = $startDate->copy()->endOfWeek(CarbonInterface::SUNDAY);

            $from = $startDate->format('Y-m-d');
            $to   = $endDate->format('Y-m-d');
        }

        $rekap = $childs->map(function ($siswa) use ($from, $to) {
            $absensiQuery = $siswa->absensi();

            if ($from) $absensiQuery->whereDate('tgl_waktu_absen', '>=', $from);
            if ($to)   $absensiQuery->whereDate('tgl_waktu_absen', '<=', $to);

            return [
                'siswa'       => $siswa,
                'totalAlpha'  => (clone $absensiQuery)->where('status_absen', 'alpha')->count(),
                'totalSakit'  => (clone $absensiQuery)->where('status_absen', 'sakit')->count(),
                'totalIzin'   => (clone $absensiQuery)->where('status_absen', 'izin')->count(),
            ];
        });

        return view('walimurid.history.index', [
            'rekap' => $rekap,
            'from'  => $from,
            'to'    => $to,
            'week'  => $week,
        ]);
    }
}
