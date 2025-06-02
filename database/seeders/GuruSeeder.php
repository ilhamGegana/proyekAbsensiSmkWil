<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('guru')->insert([
            [
                'nip' => '1234567890',
                'nama_guru' => 'Ahmad Yani',
                'telpon_guru' => '0811222333',
                'email_guru' => 'ahmad@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '0987654321',
                'nama_guru' => 'Rina Kusuma',
                'telpon_guru' => '0822333444',
                'email_guru' => 'rina@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
