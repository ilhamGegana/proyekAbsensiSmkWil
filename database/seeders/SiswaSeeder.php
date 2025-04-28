<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('siswa')->insert([
            [
                'nis' => '22001',
                'nama_siswa' => 'Rahmat Hidayat',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => '2008-01-01',
                'alamat_siswa' => 'Jl. Mawar No.1',
                'no_telp_siswa' => '0812345678',
                'id_kelas' => 1,
                'id_walimurid' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '22002',
                'nama_siswa' => 'Putri Aulia',
                'jenis_kelamin' => 'P',
                'tgl_lahir' => '2008-02-02',
                'alamat_siswa' => 'Jl. Melati No.2',
                'no_telp_siswa' => '0819876543',
                'id_kelas' => 2,
                'id_walimurid' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
