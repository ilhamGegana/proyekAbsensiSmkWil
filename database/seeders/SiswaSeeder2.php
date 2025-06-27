<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;

class SiswaSeeder2 extends Seeder
{
    public function run(): void
    {
        /* ───────── id_kelas untuk empat rombel hasil kenaikan ───────── */
        $kelasMap = [
            'TAB 11' => Kelas::firstWhere('nama_kelas', 'TAB 11')->id ?? null,
            'TAB 12' => Kelas::firstWhere('nama_kelas', 'TAB 12')->id ?? null,
            'TKJ 11' => Kelas::firstWhere('nama_kelas', 'TKJ 11')->id ?? null,
            'TKJ 12' => Kelas::firstWhere('nama_kelas', 'TKJ 12')->id ?? null,
        ];

        DB::table('siswa')->insert([
            [
                'nis'            => '0084682417',                // ADITTRIA YUSUF ADRIANTO – TAB 10 → TAB 11
                'nama_siswa'     => 'ADITTRIA YUSUF ADRIANTO',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2008-12-23',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '3081063559',                // AHMAT SOFIYAN – TAB 10 → TAB 11
                'nama_siswa'     => 'AHMAT SOFIYAN',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2008-10-18',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0099283751',                // ALFINO PUTRA SUSANTO – TAB 10 → TAB 11
                'nama_siswa'     => 'ALFINO PUTRA SUSANTO',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2009-03-20',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0076267274',                // AMELIA NUR SYAFITRI – TKJ 10 → TKJ 11
                'nama_siswa'     => 'AMELIA NUR SYAFITRI',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2007-10-10',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0085511370',                // Andrian Putra Aziztian – TAB 10 → TAB 11
                'nama_siswa'     => 'Andrian Putra Aziztian',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2008-08-13',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0082777531',                // Arvin Sugin Viransah – TAB 10 → TAB 11
                'nama_siswa'     => 'Arvin Sugin Viransah',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2008-10-21',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0073714547',                // AYU ALFIYATUNNI'MAH – TKJ 11 → TKJ 12
                'nama_siswa'     => "AYU ALFIYATUNNI'MAH",
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2007-08-25',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 12'],
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0037505381',          // BAYU AJI SAPUTRA
                'nama_siswa'     => 'BAYU AJI SAPUTRA',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2003-03-10',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 dipromosikan → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0073245746',          // BERTHA ERIESTHA SARI
                'nama_siswa'     => 'BERTHA ERIESTHA SARI',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2007-09-29',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],   // TAB 10 → TAB 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0081213606',          // Bintang Yudha Syaktiawan
                'nama_siswa'     => 'Bintang Yudha Syaktiawan',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2008-03-12',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],   // TAB 10 → TAB 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0077233722',          // Catur Putri Wulandari
                'nama_siswa'     => 'Catur Putri Wulandari',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2007-06-05',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0072221712',          // Cindy Desta Mentari
                'nama_siswa'     => 'CINDY DESTA MENTARI',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2007-12-21',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0075429362',          // Daffa Ahmad Fambudi
                'nama_siswa'     => 'Daffa Ahmad Fambudi',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2007-11-17',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 12'],   // TAB 11 → TAB 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0098104635',          // Dewi Alfiatu Ni'mah
                'nama_siswa'     => "Dewi Alfiatu Ni'mah",
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2009-04-08',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0093278318',          // Dirham Virda Anggara Saputra
                'nama_siswa'     => 'DIRHAM VIRDA ANGGARA SAPUTRA',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2009-06-21',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],   // TAB 10 → TAB 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0072338964',          // 26. EKA AGUNG KURNIAWAN
                'nama_siswa'     => 'EKA AGUNG KURNIAWAN',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2007-08-19',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 12'],   // TAB 11 → TAB 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0084898692',          // 28. Eko Puji Prastiyo
                'nama_siswa'     => 'Eko Puji Prastiyo',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2005-01-01',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 12'],   // TAB 11 → TAB 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0082936011',          // 29. HAFIDL RIDWAN
                'nama_siswa'     => 'HAFIDL RIDWAN',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2008-05-18',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],   // TAB 10 → TAB 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0075902933',          // 30. IRFAN MAULANA
                'nama_siswa'     => 'IRFAN MAULANA',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2007-05-07',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],   // TAB 10 → TAB 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0082916977',          // 34. KIKY MEYLAN NURPRASETYO
                'nama_siswa'     => 'KIKY MEYLAN NURPRASETYO',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2008-05-15',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 12'],   // TKJ 11 → TKJ 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0075256112',          // 35. KOMSATUN NIKMAH TUS ZAHRA
                'nama_siswa'     => 'KOMSATUN NIKMAH TUS ZAHRA',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2007-07-18',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0082475539',          // 36. M. AGUS SETIAWAN
                'nama_siswa'     => 'M. AGUS SETIAWAN',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2007-08-21',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 12'],   // TAB 11 → TAB 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0071711128',          // 37. MARSELA CANTIKA WULANDARI
                'nama_siswa'     => 'MARSELA CANTIKA WULANDARI',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2007-09-27',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0085312971',          // 39. Mohamad Raihan Al Hamzi
                'nama_siswa'     => 'Mohamad Raihan Al Hamzi',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2008-03-04',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0033584224',          // 41. Muhamad Hilal Putra Ali Ansa
                'nama_siswa'     => 'Muhamad Hilal Putra Ali Ansa',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2007-12-06',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 12'],   // TKJ 11 → TKJ 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0073571221',          // 42. MUHAMMAD RIZKY NUGROHO
                'nama_siswa'     => 'MUHAMMAD RIZKY NUGROHO',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2007-11-06',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 12'],   // TAB 11 → TAB 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0077072619',          // 43. Muhammad Rudi Santoso
                'nama_siswa'     => 'Muhammad Rudi Santoso',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2007-11-25',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],   // TAB 10 → TAB 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '3075856306',          // 44. NAULYA FADHELA SHAKILA
                'nama_siswa'     => 'NAULYA FADHELA SHAKILA',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2006-12-12',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0098311409',          // 45. Nida'ul Khasanah
                'nama_siswa'     => "Nida'ul Khasanah",
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2009-07-05',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0046804666',      // 46 Pandu Pratama
                'nama_siswa'     => 'Pandu Pratama',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2004-12-31',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 12'],   // TAB 11 → TAB 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0072100654',      // 47 PRISKA ANINDITA SAPUTRI
                'nama_siswa'     => 'PRISKA ANINDITA SAPUTRI',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2007-08-24',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0076249375',      // 48 Pulung Arga Untoro
                'nama_siswa'     => 'Pulung Arga Untoro',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2007-05-15',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 12'],   // TAB 11 → TAB 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0077475148',      // 49 Raffy Dwi Agustino
                'nama_siswa'     => 'Raffy Dwi Agustino',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2007-08-31',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 12'],   // TKJ 11 → TKJ 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '3071271742',      // 50 RANGGA OKTAV ARDYANSYAH
                'nama_siswa'     => 'RANGGA OKTAV ARDYANSYAH',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2007-10-20',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 12'],   // TAB 11 → TAB 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0061640660',      // 51 RAVI KUMARAN
                'nama_siswa'     => 'RAVI KUMARAN',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2006-05-23',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 12'],   // TAB 11 → TAB 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0089063315',      // 53 REVA TRIO ANANDA
                'nama_siswa'     => 'REVA TRIO ANANDA',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2008-02-19',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '3094132615',      // 54 RIDHO AJI CHOIRONI
                'nama_siswa'     => 'RIDHO AJI CHOIRONI',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2009-04-13',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '3097773980',      // 55 SINTIA RAHMAWATI
                'nama_siswa'     => 'SINTIA RAHMAWATI',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2009-03-31',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0063617030',      // 56. Siti Nur Cholifah
                'nama_siswa'     => 'Siti Nur Cholifah',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2006-02-19',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 12'],   // TKJ 11 → TKJ 12
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0077430296',      // 57. SITI NURHASANAH
                'nama_siswa'     => 'SITI NURHASANAH',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2007-04-19',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],   // TAB 10 → TAB 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0083675725',      // 59. Umi Sahudah
                'nama_siswa'     => 'Umi Sahudah',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2008-01-07',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '3063134256',          // 62. YESA APRILIA
                'nama_siswa'     => 'YESA APRILIA',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2006-04-26',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '3061661066',          // 63. YESI APRILIA
                'nama_siswa'     => 'YESI APRILIA',
                'signature_data' => null,
                'jenis_kelamin'  => 'P',
                'tgl_lahir'      => '2006-04-26',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TKJ 11'],   // TKJ 10 → TKJ 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nis'            => '0095127020',          // 64. YOGA DWI PRASETYO
                'nama_siswa'     => 'YOGA DWI PRASETYO',
                'signature_data' => null,
                'jenis_kelamin'  => 'L',
                'tgl_lahir'      => '2009-10-20',
                'alamat_siswa'   => null,
                'no_telp_siswa'  => null,
                'id_kelas'       => $kelasMap['TAB 11'],   // TAB 10 → TAB 11
                'id_walimurid'   => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
