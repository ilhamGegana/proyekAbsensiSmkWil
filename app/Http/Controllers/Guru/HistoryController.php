<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Siswa, Kelas, JadwalPelajaran};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonInterface;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;

        $from        = $request->input('from');
        $to          = $request->input('to');
        $nameFilter  = $request->input('name');
        $kelasFilter = $request->input('class');
        $weekFilter  = $request->input('week');

        // Jika memilih minggu ke-N, generate tanggal from dan to secara otomatis
        if ($weekFilter) {
            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth();
            $startDate = $startOfMonth->copy()->addWeeks($weekFilter - 1)->startOfWeek(CarbonInterface::MONDAY);
            $endDate = $startDate->copy()->endOfWeek(CarbonInterface::SUNDAY);

            $from = $startDate->format('Y-m-d');
            $to = $endDate->format('Y-m-d');
        }

        $today = Carbon::today();
        $hariIni = $today->isoFormat('dddd');

        $kelasIds = JadwalPelajaran::aktif()
            ->where('id_guru', $guru->id)
            ->where('hari', $hariIni)
            ->pluck('id_kelas')
            ->unique()
            ->toArray();

        $students = Siswa::with('kelas')
            ->whereIn('id_kelas', $kelasIds)
            ->when($nameFilter, fn($q) => $q->where('nama_siswa', 'like', "%{$nameFilter}%"))
            ->when($kelasFilter, fn($q) => $q->where('id_kelas', $kelasFilter))
            ->withCount([
                'absensi as alpha_count' => fn($q) =>
                $q->where('status_absen', 'alpha')
                    ->when($from, fn($q) => $q->whereDate('tgl_waktu_absen', '>=', $from))
                    ->when($to, fn($q) => $q->whereDate('tgl_waktu_absen', '<=', $to)),
                'absensi as sakit_count' => fn($q) =>
                $q->where('status_absen', 'sakit')
                    ->when($from, fn($q) => $q->whereDate('tgl_waktu_absen', '>=', $from))
                    ->when($to, fn($q) => $q->whereDate('tgl_waktu_absen', '<=', $to)),
                'absensi as izin_count' => fn($q) =>
                $q->where('status_absen', 'izin')
                    ->when($from, fn($q) => $q->whereDate('tgl_waktu_absen', '>=', $from))
                    ->when($to, fn($q) => $q->whereDate('tgl_waktu_absen', '<=', $to)),
            ])
            ->orderBy('nama_siswa')
            ->get();

        $classes = Kelas::whereIn('id', $kelasIds)
            ->orderBy('nama_kelas')
            ->get();

        return view('guru.history.index', [
            'students' => $students,
            'classes' => $classes,
            'from' => $from,
            'to' => $to,
            'name' => $nameFilter,
            'kelas' => $kelasFilter,
            'week' => $weekFilter,
        ]);
    }
}
