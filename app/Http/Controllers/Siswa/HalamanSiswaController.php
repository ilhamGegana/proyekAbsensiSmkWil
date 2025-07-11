<?php

namespace App\Http\Controllers\Siswa;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\CarbonInterface;

class HalamanSiswaController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;   // relasi user → siswa
        return view('siswa.home.index', compact('siswa'));
    }

    public function history(Request $request)
    {
        $siswa = Auth::user()->siswa;

        $from       = $request->input('from');
        $to         = $request->input('to');
        $weekFilter = $request->input('week');

        // Jika filter "minggu ke-N" dipilih, hitung tanggal dari–sampai secara otomatis
        if ($weekFilter) {
            $now = now();
            $startOfMonth = $now->copy()->startOfMonth();
            $startDate = $startOfMonth->copy()->addWeeks($weekFilter - 1)->startOfWeek(CarbonInterface::MONDAY);
            $endDate = $startDate->copy()->endOfWeek(CarbonInterface::SUNDAY);

            $from = $startDate->format('Y-m-d');
            $to   = $endDate->format('Y-m-d');
        }

        // Hitung total berdasarkan status absen dan tanggal (jika ada)
        $totalAlpha = $siswa->absensi()
            ->where('status_absen', 'alpha')
            ->when($from, fn($q) => $q->whereDate('tgl_waktu_absen', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('tgl_waktu_absen', '<=', $to))
            ->count();

        $totalSakit = $siswa->absensi()
            ->where('status_absen', 'sakit')
            ->when($from, fn($q) => $q->whereDate('tgl_waktu_absen', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('tgl_waktu_absen', '<=', $to))
            ->count();

        $totalIzin = $siswa->absensi()
            ->where('status_absen', 'izin')
            ->when($from, fn($q) => $q->whereDate('tgl_waktu_absen', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('tgl_waktu_absen', '<=', $to))
            ->count();

        return view('siswa.history.index', [
            'siswa'       => $siswa,
            'totalAlpha'  => $totalAlpha,
            'totalSakit'  => $totalSakit,
            'totalIzin'   => $totalIzin,
            'from'        => $from,
            'to'          => $to,
            'week'        => $weekFilter,
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
