<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'id_siswa' => 1,
                'username' => 'rahmat',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_guru' => 1,
                'username' => 'ahmad',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_walimurid' => 1, // Pastikan walimurid id 1 sudah ada
                'username' => 'walimurid1',
                'password' => Hash::make('password123'),
                'role' => 'walimurid',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_siswa' => null,
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
