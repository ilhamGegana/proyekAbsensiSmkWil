<?php
// database/seeders/JadwalJumatSeeder.php

namespace Database\Seeders;

use App\Models\{JadwalPelajaran, Mapel, Kelas};
use Illuminate\Database\Seeder;

class JadwalJumatFullSeeder extends Seeder
{
    public function run(): void
    {
        /* ----------------------------------------------------------
         * 1) urutan kolom → nama kelas
         * -------------------------------------------------------- */
        $kelasMap = [
            'TAB 10',   // kolom-1
            'TKJ 10',   // kolom-2
            'TAB 11',  // kolom-3
            'TKJ 11',  // kolom-4
            'TAB 12', // kolom-5
            'TKJ 12', // kolom-6
        ];

        /* ----------------------------------------------------------
         * 2) isi slot jam_ke (0-4) - string kosong = dilewati
         * -------------------------------------------------------- */
        $slots = [
            0 => ['',   '',     '',      '',     '',     ''],            // Screening
            1 => ['BK', 'BK',   'TAB',   'TKJ',  'KWU',  'KWU'],
            2 => ['BK', 'BK',   'TAB',   'TKJ',  'KWU',  'KWU'],
            3 => ['B.JW','B.JW','SEJ.INA','SEJ.INA','TAB','TKJ'],
            4 => ['B.JW','B.JW','SEJ.INA','SEJ.INA','TAB','TKJ'],
            // slot 5-9 tidak ada jadwal, biarkan kosong
        ];

        /* ----------------------------------------------------------
         * 3) loop & firstOrCreate
         * -------------------------------------------------------- */
        foreach ($kelasMap as $col => $namaKelas) {

            $kelas = Kelas::where('nama_kelas', $namaKelas)->firstOrFail();

            foreach ($slots as $jamKe => $row) {

                $kode = $row[$col] ?? '';

                if ($kode === '' || $kode === null) continue;   // lewati slot kosong

                $mapel = Mapel::where('kode_mapel', $kode)->firstOrFail();

                JadwalPelajaran::firstOrCreate(
                    [
                        'hari'     => 'Jumat',
                        'jam_ke'   => $jamKe,
                        'id_kelas' => $kelas->id,
                    ],
                    [
                        'id_mapel' => $mapel->id,
                        'id_guru'  => $mapel->id_guru,
                        'is_active'=> true,
                    ]
                );
            }
        }
    }
}
