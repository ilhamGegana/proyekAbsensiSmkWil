<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
                'nama_kelas' => 'X IPA 1',
                'tingkat' => 10,
                'id_guru' => 1, // sesuaikan dengan id_guru yang sudah disediakan
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kelas' => 'X IPS 1',
                'tingkat' => 10,
                'id_guru' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
