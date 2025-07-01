<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder2 extends Seeder
{
    public function run(): void
    {
        $siswaList = [
            ['id' => 6, 'nama_siswa' => 'ADITTRIA YUSUF ADRIANTO'],
            ['id' => 7, 'nama_siswa' => 'AHMAT SOFIYAN'],
            ['id' => 8, 'nama_siswa' => 'ALFINO PUTRA SUSANTO'],
            ['id' => 10, 'nama_siswa' => 'Andrian Putra Aziztian'],
            ['id' => 11, 'nama_siswa' => 'Arvin Sugin Viransah'],
            ['id' => 13, 'nama_siswa' => 'BAYU AJI SAPUTRA'],
            ['id' => 14, 'nama_siswa' => 'BERTHA ERIESTHA SARI'],
            ['id' => 15, 'nama_siswa' => 'Bintang Yudha Syaktiawan'],
            ['id' => 16, 'nama_siswa' => 'Catur Putri Wulandari'],
            ['id' => 17, 'nama_siswa' => 'CINDY DESTA MENTARI'],
            ['id' => 18, 'nama_siswa' => 'Daffa Ahmad Fambudi'],
            ['id' => 19, 'nama_siswa' => "Dewi Alfiatu Ni'mah"],
            ['id' => 20, 'nama_siswa' => 'DIRHAM VIRDA ANGGARA SAPUTRA'],
            ['id' => 21, 'nama_siswa' => 'EKA AGUNG KURNIAWAN'],
            ['id' => 22, 'nama_siswa' => 'Eko Puji Prastiyo'],
            ['id' => 23, 'nama_siswa' => 'HAFIDL RIDWAN'],
            ['id' => 24, 'nama_siswa' => 'IRFAN MAULANA'],
            ['id' => 26, 'nama_siswa' => 'KOMSATUN NIKMAH TUS ZAHRA'],
            ['id' => 27, 'nama_siswa' => 'M. AGUS SETIAWAN'],
            ['id' => 28, 'nama_siswa' => 'MARSELA CANTIKA WULANDARI'],
            ['id' => 29, 'nama_siswa' => 'Mohamad Raihan Al Hamzi'],
            ['id' => 31, 'nama_siswa' => 'MUHAMMAD RIZKY NUGROHO'],
            ['id' => 32, 'nama_siswa' => 'Muhammad Rudi Santoso'],
            ['id' => 33, 'nama_siswa' => 'NAULYA FADHELA SHAKILA'],
            ['id' => 34, 'nama_siswa' => "Nida'ul Khasanah"],
            ['id' => 35, 'nama_siswa' => 'Pandu Pratama'],
            ['id' => 36, 'nama_siswa' => 'PRISKA ANINDITA SAPUTRI'],
            ['id' => 37, 'nama_siswa' => 'Pulung Arga Untoro'],
            ['id' => 39, 'nama_siswa' => 'RANGGA OKTAV ARDYANSYAH'],
            ['id' => 40, 'nama_siswa' => 'RAVI KUMARAN'],
            ['id' => 41, 'nama_siswa' => 'REVA TRIO ANANDA'],
            ['id' => 42, 'nama_siswa' => 'RIDHO AJI CHOIRONI'],
            ['id' => 43, 'nama_siswa' => 'SINTIA RAHMAWATI'],
            ['id' => 45, 'nama_siswa' => 'SITI NURHASANAH'],
            ['id' => 46, 'nama_siswa' => 'Umi Sahudah'],
            ['id' => 47, 'nama_siswa' => 'YESA APRILIA'],
            ['id' => 48, 'nama_siswa' => 'YESI APRILIA'],
            ['id' => 49, 'nama_siswa' => 'YOGA DWI PRASETYO'],
        ];

        foreach ($siswaList as $siswa) {
            $baseUsername = strtolower(strtok($siswa['nama_siswa'], ' '));
            $username = $baseUsername;
            $counter = 1;

            // cek apakah username sudah ada, jika ya tambahkan angka sampai unik
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }

            User::create([
                'id_siswa' => $siswa['id'],
                'id_guru' => null,
                'id_walimurid' => null,
                'username' => $username,
                'password' => Hash::make('12345678'),
                'role' => 'siswa',
                'status_aktif' => '1',
            ]);
        }
    }
}
