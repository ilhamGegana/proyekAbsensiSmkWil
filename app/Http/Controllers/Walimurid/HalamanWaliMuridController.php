<?php

namespace App\Http\Controllers\Walimurid;

use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HalamanWaliMuridController extends Controller
{
    public function index()
    {
        return view('walimurid.home.index');
    }

    public function history(Request $request)
    {
        $wali = Auth::user()->walimurid;            // wali yg login
        $childIds = $wali->siswa()->pluck('id');        // id semua anak

        /* ─── query dasar: hanya anak wali ini ─── */
        $attendances = Absensi::with('siswa.kelas')
            ->whereIn('id_siswa', $childIds);

        /* ─── FILTER TANGGAL: sama persis dg guru/siswa ─── */
        $from = $request->input('from');   // yyyy-mm-dd
        $to   = $request->input('to');

        if ($from && !$to) {
            $attendances->whereDate('tgl_waktu_absen', $from);
        } elseif ($to && !$from) {
            $attendances->whereDate('tgl_waktu_absen', $to);
        } elseif ($from && $to) {
            $attendances->whereBetween('tgl_waktu_absen', [$from, $to]);
        }

        /* ─── FILTER NAMA / KELAS (opsional) ─── */
        if ($request->filled('name')) {
            $attendances->whereHas('siswa', fn($q) =>
            $q->where('nama_siswa', 'like', '%' . $request->name . '%'));
        }

        if ($request->filled('class')) {
            $attendances->whereHas('siswa', fn($q) =>
            $q->where('id_kelas', $request->class));
        }

        $attendances = $attendances
            ->orderBy('tgl_waktu_absen', 'desc')
            ->get();

        /* dropdown kelas (hanya kelas anak² wali ini saja) */
        $classes = Kelas::whereIn(
            'id',
            $wali->siswa()->pluck('id_kelas')->unique()
        )->orderBy('nama_kelas')->get();

        return view('walimurid.history.index', [
            'attendances' => $attendances,
            'classes'     => $classes,
            'from'        => $from,
            'to'          => $to,
        ]);
    }
}
