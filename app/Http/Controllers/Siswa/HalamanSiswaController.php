<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class HalamanSiswaController extends Controller
{
    public function index()
    {
        return view('siswa.home.index');
    }

    public function history(Request $request)
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

        return view('siswa.history.index', compact('attendances', 'classes'));
    }

    /** POST /siswa/generate-code */
    public function generateCode(): JsonResponse
    {
        // 1. Ambil siswa yang sedang login (lihat relasi di model User)
        $user  = Auth::user();               // role: siswa
        $siswa = $user->siswa;               // belongsTo di User.php

        // 2. Pastikan relasi wali ada
        if (!$siswa || !$siswa->walimurid) {
            return response()->json(
                [
                    'message' => 'Data wali tidak ditemukan. Hubungi admin.'
                ],
                404
            );
        }

        $wali = $siswa->walimurid;           // belongsTo di Siswa.php

        // 3. Buat / ambil kode aktif
        $code = $wali->ensureRegCode();      // helper di model WaliMurid

        // 4. Balikkan ke front-end
        return response()->json([
            'code'    => $code,
            'expires' => $wali->reg_code_expires?->format('d-m-Y H:i'),
        ]);
    }
}
