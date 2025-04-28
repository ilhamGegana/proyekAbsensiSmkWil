<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('absensi')->insert([
            [
                'id_siswa' => 1,
                'id_jadwal' => 1,
                'signature_ref' => null,
                'status_absen' => 'Hadir',
                'tgl_waktu_absen' => now(),
                'keterangan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_siswa' => 2,
                'id_jadwal' => 2,
                'signature_ref' => null,
                'status_absen' => 'Sakit',
                'tgl_waktu_absen' => now(),
                'keterangan' => 'Demam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
