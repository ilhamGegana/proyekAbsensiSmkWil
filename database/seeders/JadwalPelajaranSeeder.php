<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwal_pelajaran')->insert([
            [
                'hari' => 'Senin',
                'id_guru' => 1,
                'id_mapel' => 1,
                'id_kelas' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hari' => 'Selasa',
                'id_guru' => 2,
                'id_mapel' => 2,
                'id_kelas' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
