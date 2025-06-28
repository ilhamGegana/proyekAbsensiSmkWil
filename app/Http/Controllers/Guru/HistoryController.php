<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Absensi::with(['siswa.kelas']);

        /* ─── FILTER TANGGAL DARI – SAMPAI ─── */
        $from = $request->input('from');   // contoh: 2025-06-01
        $to   = $request->input('to');     // contoh: 2025-06-30

        // jika hanya "from" → >= from
        if ($from && !$to) {
            $attendances->whereDate('tgl_waktu_absen', '>=', $from);
        }
        // jika hanya "to"   → <= to
        elseif ($to && !$from) {
            $attendances->whereDate('tgl_waktu_absen', '<=', $to);
        }
        // jika keduanya     → between
        elseif ($from && $to) {
            $attendances->whereBetween('tgl_waktu_absen', [$from, $to]);
        }

        /* ─── FILTER NAMA & KELAS (tidak berubah) ─── */
        if ($request->filled('name')) {
            $attendances->whereHas('siswa', fn($q) =>
            $q->where('nama_siswa', 'like', '%' . $request->name . '%'));
        }

        if ($request->filled('class')) {
            $attendances->whereHas('siswa', fn($q) =>
            $q->where('id_kelas', $request->class));
        }

        $attendances = $attendances->get();

        $classes = Kelas::select('id', 'nama_kelas')->orderBy('nama_kelas')->get();

        return view('guru.history.index', compact('attendances', 'classes'))
            ->with([
                'from' => $from,
                'to'   => $to,
            ]);
    }
}
