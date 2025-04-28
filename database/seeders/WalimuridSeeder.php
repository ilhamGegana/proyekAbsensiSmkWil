<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalimuridSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('walimurid')->insert([
            [
                'nama_walimurid' => 'Budi Santoso',
                'telpon_walimurid' => '08123456789',
                'email_walimurid' => 'budi@example.com',
                'alamat_walimurid' => 'Jl. Merdeka No.1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_walimurid' => 'Siti Aminah',
                'telpon_walimurid' => '08987654321',
                'email_walimurid' => 'siti@example.com',
                'alamat_walimurid' => 'Jl. Sudirman No.2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
