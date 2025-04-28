<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notifikasi')->insert([
            [
                'id_guru' => 1,
                'id_siswa' => 1,
                'pesan' => 'Siswa Rahmat hadir hari ini.',
                'waktu_kirim' => now(),
                'tujuan' => 'Walimurid',
                'status_kirim' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_guru' => 2,
                'id_siswa' => 2,
                'pesan' => 'Siswa Putri sakit.',
                'waktu_kirim' => now(),
                'tujuan' => 'Walimurid',
                'status_kirim' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
