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
        // --- query builder dasar ---
        $attendances = Absensi::with(['siswa.kelas']);

        // filter tanggal (kolom tgl_waktu_absen)
        if ($request->filled('date')) {
            $attendances->whereDate('tgl_waktu_absen', $request->date);
        }

        // filter nama siswa
        if ($request->filled('name')) {
            $attendances->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->name . '%');
            });
        }

        // filter kelas (berdasar id_kelas)
        if ($request->filled('class')) {
            $attendances->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->class);
            });
        }

        $attendances = $attendances->get();

        // daftar kelas untuk dropdown
        $classes = Kelas::select('id', 'nama_kelas')->orderBy('nama_kelas')->get();

        return view('guru.history.index', compact('attendances', 'classes'));
    }
}
