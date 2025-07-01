<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserGuruSeeder extends Seeder
{
    public function run(): void
    {
        $guruList = [
            ['id' => 2, 'nama_guru' => 'Rina Kusuma'],
            ['id' => 8, 'nama_guru' => 'Yono Alam'],
            ['id' => 10, 'nama_guru' => 'Lily Sri Lestari,S.Pd'],
            ['id' => 11, 'nama_guru' => 'Fatkur Rohman,ST.M.Si'],
            ['id' => 12, 'nama_guru' => 'Drs.Yoyok Ismoyo'],
            ['id' => 13, 'nama_guru' => 'Miftakhul Huda A.M.KOM'],
            ['id' => 14, 'nama_guru' => 'Fahmi Amrilah S. R, A.M.KOM'],
            ['id' => 15, 'nama_guru' => 'Masrukhin Nuridwan'],
            ['id' => 16, 'nama_guru' => 'Lidawati,S.Pd'],
            ['id' => 17, 'nama_guru' => 'Achmad Rifa\'i,S.Ag'],
            ['id' => 18, 'nama_guru' => 'Yolanda Cici Wulandari,S.Pd'],
            ['id' => 19, 'nama_guru' => 'Khoirul Azasi,S.E'],
            ['id' => 20, 'nama_guru' => 'Rudi Hartono'],
            ['id' => 21, 'nama_guru' => 'Niswatul Mukaromah,S.Pd'],
            ['id' => 22, 'nama_guru' => 'Nur Rekha Yuan Agatha,S.Pd'],
        ];

        foreach ($guruList as $guru) {
            $baseUsername = strtolower(strtok($guru['nama_guru'], ' ')); // nama depan
            $username = $baseUsername;
            $counter = 1;

            // Cek keunikan username
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }

            User::create([
                'id_guru' => $guru['id'],
                'id_siswa' => null,
                'id_walimurid' => null,
                'username' => $username,
                'password' => Hash::make('12345678'),
                'role' => 'guru',
                'status_aktif' => '1',
            ]);
        }
    }
}
