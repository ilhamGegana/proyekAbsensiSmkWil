<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\PngEncoder;

class HalamanSiswaController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;   // relasi user → siswa
        return view('siswa.home.index', compact('siswa'));
    }

    public function history(Request $request)
    {
        Log::debug('HIST', $request->all());
        $siswa = Auth::user()->siswa;        // siswa yang login

        /* ─── query dasar: hanya id_siswa ini ─── */
        $attendances = Absensi::with('siswa.kelas')
            ->where('id_siswa', $siswa->id);

        /* ─── filter range tanggal ─── */
        $from = $request->input('from');   // yyyy-mm-dd
        $to   = $request->input('to');

        if ($from && !$to) {
            // hanya ‘dari’ → persis tanggal itu
            $attendances->whereDate('tgl_waktu_absen', $from);
        } elseif ($to && !$from) {
            // hanya ‘sampai’ → persis tanggal itu
            $attendances->whereDate('tgl_waktu_absen', $to);
        } elseif ($from && $to) {
            // keduanya → antara
            $attendances->whereBetween('tgl_waktu_absen', [$from, $to]);
        }

        $attendances = $attendances->orderBy('tgl_waktu_absen', 'desc')->get();

        /* kelas dropdown tidak perlu — hapus saja */
        return view('siswa.history.index', [
            'attendances' => $attendances,
            'from'        => $from,
            'to'          => $to,
        ]);
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
    public function storeSignature(Request $request): JsonResponse
    {
        $request->validate([
            'signature' => 'required|string',
        ]);

        $siswa = Auth::user()->siswa;

        if ($siswa->signature_data) {
            return response()->json([
                'ok'      => false,
                'message' => 'Tanda tangan sudah pernah disimpan dan tidak dapat diganti.',
            ], 422);
        }

        try {
            $dataUri   = str_replace(' ', '+', $request->signature);
            $img       = Image::read($dataUri)
                ->trim()
                ->resizeCanvas(600, 200, 'ffffff', 'center');
            $pngBinary = (string) $img->toPng();
            $base64    = 'data:image/png;base64,' . base64_encode($pngBinary);

            $siswa->update(['signature_data' => $base64]);

            return response()->json([
                'ok'   => true,
                'data' => $base64,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok'      => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage(),
            ], 500);
        }
    }
}