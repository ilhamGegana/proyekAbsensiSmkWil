<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserWaliMurid extends Seeder
{
    public function run(): void
    {
        $walimuridList = [
            ['id' => 2, 'nama' => 'Siti Aminah'],
            ['id' => 84, 'nama' => 'Darmo'],
            ['id' => 87, 'nama' => 'Kuwati'],
            ['id' => 89, 'nama' => 'Heru Susanto'],
            ['id' => 90, 'nama' => 'Siti Sofiyah'],
            ['id' => 91, 'nama' => 'Warjito'],
            ['id' => 92, 'nama' => 'Sugin'],
            ['id' => 96, 'nama' => 'Muhdorin'],
            ['id' => 97, 'nama' => 'Satrisno'],
            ['id' => 98, 'nama' => 'Kasdi Purnomo'],
            ['id' => 100, 'nama' => 'G. Darmoko'],
            ['id' => 101, 'nama' => 'Syarofah Ida Nurul Khomaini'],
            ['id' => 102, 'nama' => 'Dwi Irnawan'],
            ['id' => 103, 'nama' => 'Laminto'],
            ['id' => 106, 'nama' => 'Supriadi AT'],
            ['id' => 107, 'nama' => 'Suyono'],
            ['id' => 108, 'nama' => 'Eva Surya Ningsih'],
            ['id' => 110, 'nama' => 'SUGIONO'],
            ['id' => 115, 'nama' => 'Katemin'],
            ['id' => 116, 'nama' => 'PANIMIN'],
            ['id' => 117, 'nama' => 'JOKO UMBARAN'],
            ['id' => 119, 'nama' => 'Fajar Wibowo'],
            ['id' => 122, 'nama' => 'Mariyanto'],
            ['id' => 123, 'nama' => 'Sutarno'],
            ['id' => 124, 'nama' => 'Yuli Priyanto'],
            ['id' => 125, 'nama' => 'Komsatun'],
            ['id' => 126, 'nama' => 'Sulistyono'],
            ['id' => 127, 'nama' => 'BAMBANG IRAWAN'],
            ['id' => 128, 'nama' => 'Slamet'],
            ['id' => 130, 'nama' => 'JOKO SATRIO BAGUS'],
            ['id' => 131, 'nama' => 'SYAIFUL HIDAYAT'],
            ['id' => 133, 'nama' => 'SOETIYO'],
            ['id' => 134, 'nama' => 'Slamet Aryadi'],
            ['id' => 135, 'nama' => 'Umi Rubiatin'],
            ['id' => 137, 'nama' => 'Turyanto'],
            ['id' => 139, 'nama' => 'Sumadi'],
            ['id' => 142, 'nama' => 'KUSNAN'],
            ['id' => 143, 'nama' => 'Sunardi'],
            ['id' => 144, 'nama' => 'SUYONO'],
        ];

        foreach ($walimuridList as $wali) {
            $baseUsername = strtolower(strtok($wali['nama'], ' ')); // ambil nama depan
            $username = $baseUsername;
            $counter = 1;

            // pastikan username unik
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }

            User::create([
                'id_walimurid' => $wali['id'],
                'id_siswa' => null,
                'id_guru' => null,
                'username' => $username,
                'password' => Hash::make('12345678'),
                'role' => 'walimurid',
                'status_aktif' => '1',
            ]);
        }
    }
}
