<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            WalimuridSeeder::class,
            GuruSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,
            MapelSeeder::class,
            JadwalPelajaranSeeder::class,
            AbsensiSeeder::class,
            NotifikasiSeeder::class,
            UserSeeder::class,
        ]);
    }
}
