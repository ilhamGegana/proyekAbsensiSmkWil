<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserKelasId3 extends Seeder
{
    public function run(): void
    {
        DB::table('siswa')->insert([
            [
                'nis'            => '9000000001',
                'nama_siswa'     => 'Siswa Contoh Satu',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2009-01-15',
                'alamat_siswa'   => 'Jl. Contoh No.1',
                'no_telp_siswa'  => '081234567890',
                'id_kelas'       => 3,
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '9000000002',
                'nama_siswa'     => 'Siswa Contoh Dua',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2009-02-20',
                'alamat_siswa'   => 'Jl. Contoh No.2',
                'no_telp_siswa'  => '081234567891',
                'id_kelas'       => 3,
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '9000000003',
                'nama_siswa'     => 'Siswa Contoh Tiga',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2009-03-10',
                'alamat_siswa'   => 'Jl. Contoh No.3',
                'no_telp_siswa'  => '081234567892',
                'id_kelas'       => 3,
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '9000000004',
                'nama_siswa'     => 'Siswa Contoh Empat',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2009-04-05',
                'alamat_siswa'   => 'Jl. Contoh No.4',
                'no_telp_siswa'  => '081234567893',
                'id_kelas'       => 3,
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '9000000005',
                'nama_siswa'     => 'Siswa Contoh Lima',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2009-05-12',
                'alamat_siswa'   => 'Jl. Contoh No.5',
                'no_telp_siswa'  => '081234567894',
                'id_kelas'       => 3,
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
