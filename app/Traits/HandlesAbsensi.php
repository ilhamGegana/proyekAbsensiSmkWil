<?php

namespace App\Traits;

use App\Models\Absensi;
use Illuminate\Support\Carbon;

trait HandlesAbsensi
{
    /**
     * Simpan / perbarui absensi.
     *
     * • Baris unik = id_siswa + id_jadwal + tanggal (tanpa jam)  
     * • Kolom tgl_waktu_absen SELALU di-update ke now()
     *
     * @param int        $siswaId
     * @param int        $jadwalId
     * @param array      $payload   kolom tambahan: status_absen, signature_ref, keterangan, dst.
     * @param Carbon|null $targetDate tanggal yang menjadi kunci (default = hari ini)
     */
    protected function saveAbsensi(
        int    $siswaId,
        int    $jadwalId,
        array  $payload,
        ?Carbon $targetDate = null
    ): void {
        $targetDate ??= Carbon::today();

        $absensi = Absensi::where('id_siswa',  $siswaId)
            ->where('id_jadwal', $jadwalId)
            ->whereDate('tgl_waktu_absen', $targetDate)
            ->first();

        if ($absensi) {
            // baris sudah ada → perbarui jam + kolom lain
            $absensi->update($payload + ['tgl_waktu_absen' => now()]);
        } else {
            // baris baru
            Absensi::create([
                'id_siswa'        => $siswaId,
                'id_jadwal'       => $jadwalId,
                'tgl_waktu_absen' => now(),
            ] + $payload);
        }
    }
}
