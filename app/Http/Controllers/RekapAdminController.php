<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Absensi, Kelas, Siswa};
use App\Exports\RekapAbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class RekapAdminController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $data = $this->getFilteredAbsensi($request);
        $rekapASI = $this->getRekapASI($request);

        return view('admin.rekap.index', [
            'data' => $data,
            'kelasList' => $kelasList,
            'rekapASI' => $rekapASI,
        ]);
    }

    public function downloadExcel(Request $request)
    {
        $rekapASI = $this->getRekapASI($request);
        $filename = 'rekap_asi_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new RekapAbsensiExport($rekapASI), $filename);
    }

    public function downloadPdf(Request $request)
    {
        $data = $this->getFilteredAbsensi($request);
        $rekapASI = $this->getRekapASI($request);

        $pdf = PDF::loadView('admin.rekap.pdf', compact('data', 'rekapASI'))->setPaper('A4', 'landscape');

        return $pdf->download('rekap_absensi_' . now()->format('Ymd_His') . '.pdf');
    }

    protected function getFilteredAbsensi(Request $request)
    {
        $query = Absensi::with(['siswa.kelas', 'jadwal.mapel']);

        $from = $request->input('tanggal_awal');
        $to   = $request->input('tanggal_akhir');
        $week = $request->input('minggu');

        if ($week) {
            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth();
            $from = $startOfMonth->copy()->addWeeks($week - 1)->startOfWeek(CarbonInterface::MONDAY)->format('Y-m-d');
            $to = Carbon::parse($from)->copy()->endOfWeek(CarbonInterface::SUNDAY)->format('Y-m-d');
        }

        if ($from && !$to) {
            $query->whereDate('tgl_waktu_absen', '>=', $from);
        } elseif ($to && !$from) {
            $query->whereDate('tgl_waktu_absen', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('tgl_waktu_absen', [$from, $to]);
        }

        if ($request->filled('kelas')) {
            $query->whereHas('siswa', fn($q) => $q->where('id_kelas', $request->kelas));
        }

        if ($request->filled('siswa')) {
            $query->whereHas('siswa', fn($q) => $q->where('nama_siswa', 'like', '%' . $request->siswa . '%'));
        }

        return $query->get();
    }

    protected function getRekapASI(Request $request)
    {
        $from = $request->input('tanggal_awal');
        $to = $request->input('tanggal_akhir');
        $week = $request->input('minggu');
        $idKelas = $request->input('kelas');
        $namaSiswa = $request->input('siswa');

        if ($week) {
            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth();
            $from = $startOfMonth->copy()->addWeeks($week - 1)->startOfWeek(CarbonInterface::MONDAY)->format('Y-m-d');
            $to = Carbon::parse($from)->copy()->endOfWeek(CarbonInterface::SUNDAY)->format('Y-m-d');
        }

        if (!$from || !$to || !$idKelas) {
            return collect(); // tidak hitung kalau filter tidak lengkap
        }

        $query = Siswa::with('kelas')
            ->where('id_kelas', $idKelas);

        if ($namaSiswa) {
            $query->where('nama_siswa', 'like', '%' . $namaSiswa . '%');
        }

        return $query->withCount([
            'absensi as alpha_count' => function ($q) use ($from, $to) {
                $q->where('status_absen', 'alpha')->whereBetween('tgl_waktu_absen', [$from, $to]);
            },
            'absensi as sakit_count' => function ($q) use ($from, $to) {
                $q->where('status_absen', 'sakit')->whereBetween('tgl_waktu_absen', [$from, $to]);
            },
            'absensi as izin_count' => function ($q) use ($from, $to) {
                $q->where('status_absen', 'izin')->whereBetween('tgl_waktu_absen', [$from, $to]);
            },
        ])->get();
    }
}
