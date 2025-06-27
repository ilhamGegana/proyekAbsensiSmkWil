<?php

namespace Database\Seeders;

use App\Models\JadwalPelajaran;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class JadwalKamisFullSeeder extends Seeder
{
    public function run(): void
    {
        /*--------------------------------------------------------------
        | 1) Peta kolom → nama kelas
        --------------------------------------------------------------*/
        $kelasMap = [
            'TAB 10',   // kolom-1
            'TKJ 10',   // kolom-2
            'TAB 11',  // kolom-3
            'TKJ 11',  // kolom-4
            'TAB 12', // kolom-5
            'TKJ 12', // kolom-6
        ];

        /*--------------------------------------------------------------
        | 2) Isi slot jam_ke (0-9) – string kosong = dilewati
        --------------------------------------------------------------*/
        $slots = [
            0 => ['',     '',      '',      '',      '',       ''],             // Screening
            1 => ['PJOK', 'PJOK',  'PJOK',  'PJOK',  'PJOK',   'PJOK'],
            2 => ['PJOK', 'PJOK',  'PJOK',  'PJOK',  'PJOK',   'PJOK'],
            3 => ['SEJ.INA','SEJ.INA','BI.1','BI.1','MTK','MTK'],
            4 => ['',     '',      '',      '',      '',       ''],             // Istirahat
            5 => ['AWJ',  'AWJ',   'MTK',   'MTK',   'KWU',    'KWU'],
            6 => ['AWJ',  'AWJ',   'MTK',   'MTK',   'KWU',    'KWU'],
            7 => ['PAI',  'PAI',   'KWU',   'KWU',   'INFO',   'INFO'],
            8 => ['',     '',      '',      '',      '',       ''],             // Shalat
            9 => ['',     '',      '',      '',      '',       ''],             // Ekstrakurikuler
        ];

        /*--------------------------------------------------------------
        | 3) Loop & buat jadwal
        --------------------------------------------------------------*/
        foreach ($kelasMap as $col => $namaKelas) {

            $kelas = Kelas::where('nama_kelas', $namaKelas)->firstOrFail();

            foreach ($slots as $jamKe => $row) {
                $kode = $row[$col] ?? '';

                if ($kode === '' || $kode === null) continue;   // skip slot kosong

                $mapel = Mapel::where('kode_mapel', $kode)->firstOrFail();

                JadwalPelajaran::firstOrCreate(
                    [
                        'hari'     => 'Kamis',
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
