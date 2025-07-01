<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Exports\RekapAbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class RekapGuruController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        // Tambahan: filter berdasarkan minggu ke-
        $weekFilter = $request->input('week');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if ($weekFilter && !$tanggalAwal && !$tanggalAkhir) {
            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth();
            $startDate = $startOfMonth->copy()->addWeeks($weekFilter - 1)->startOfWeek(CarbonInterface::MONDAY);
            $endDate = $startDate->copy()->endOfWeek(CarbonInterface::SUNDAY);

            $request->merge([
                'tanggal_awal' => $startDate->format('Y-m-d'),
                'tanggal_akhir' => $endDate->format('Y-m-d'),
            ]);
        }

        // Validasi minimal filter: jika salah satu ada, tapi yang lain belum diisi
        if ($request->filled(['tanggal_awal', 'tanggal_akhir']) && !$request->filled('kelas')) {
            return redirect()->back()
                ->with('error', 'Silakan pilih kelas untuk menampilkan rekap absensi.');
        }

        $data = $this->getFilteredAbsensi($request);
        $rekapASI = $this->getRekapASI($request);

        return view('guru.rekap.index', [
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

        $pdf = PDF::loadView('guru.rekap.pdf', compact('data', 'rekapASI'))->setPaper('A4', 'landscape');

        return $pdf->download('rekap_absensi_' . now()->format('Ymd_His') . '.pdf');
    }

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
                fn($q) => $q->where('id_kelas', $request->kelas)
            );
        }

        if ($request->filled('siswa')) {
            $query->whereHas(
                'siswa',
                fn($q) => $q->where('nama_siswa', 'like', '%' . $request->siswa . '%')
            );
        }

        return $query->get();
    }

    protected function getRekapASI(Request $request)
    {
        $from = $request->input('tanggal_awal');
        $to   = $request->input('tanggal_akhir');
        $idKelas = $request->input('kelas');
        $namaSiswa = $request->input('siswa');

        if (!$from || !$to || !$idKelas) {
            return collect();
        }

        $query = \App\Models\Siswa::with('kelas')
            ->where('id_kelas', $idKelas);

        if ($namaSiswa) {
            $query->where('nama_siswa', 'like', '%' . $namaSiswa . '%');
        }

        return $query->withCount([
            'absensi as alpha_count' => function ($q) use ($from, $to) {
                $q->where('status_absen', 'alpha')
                    ->whereBetween('tgl_waktu_absen', [$from, $to]);
            },
            'absensi as sakit_count' => function ($q) use ($from, $to) {
                $q->where('status_absen', 'sakit')
                    ->whereBetween('tgl_waktu_absen', [$from, $to]);
            },
            'absensi as izin_count' => function ($q) use ($from, $to) {
                $q->where('status_absen', 'izin')
                    ->whereBetween('tgl_waktu_absen', [$from, $to]);
            },
        ])->get();
    }
}
