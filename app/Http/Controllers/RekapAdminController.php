<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Exports\RekapAbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapAdminController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $data = $this->getFilteredAbsensi($request);

        return view('admin.rekap.index', [
            'data' => $data,
            'kelasList' => $kelasList,
        ]);
    }

    public function downloadExcel(Request $request)
    {
        $data = $this->getFilteredAbsensi($request);
        $filename = 'rekap_absensi_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new RekapAbsensiExport($data), $filename);
    }

    public function downloadPdf(Request $request)
    {
        $data = $this->getFilteredAbsensi($request);
        $pdf = PDF::loadView('admin.rekap.pdf', compact('data'))->setPaper('A4', 'landscape');

        return $pdf->download('rekap_absensi_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Ambil data absensi yang difilter dari query request
     */
    protected function getFilteredAbsensi(Request $request)
    {
        $query = Absensi::with(['siswa.kelas', 'jadwal.mapel']);

        $from = $request->input('tanggal_awal');
        $to   = $request->input('tanggal_akhir');

        if ($from && !$to) {
            $query->whereDate('tgl_waktu_absen', '>=', $from);
        } elseif ($to && !$from) {
            $query->whereDate('tgl_waktu_absen', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('tgl_waktu_absen', [$from, $to]);
        }

        if ($request->filled('kelas')) {
            $query->whereHas(
                'siswa',
                fn($q) =>
                $q->where('id_kelas', $request->kelas)
            );
        }

        if ($request->filled('siswa')) {
            $query->whereHas(
                'siswa',
                fn($q) =>
                $q->where('nama_siswa', 'like', '%' . $request->siswa . '%')
            );
        }

        return $query->get();
    }
}
