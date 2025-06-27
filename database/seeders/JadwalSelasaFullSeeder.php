<?php

namespace Database\Seeders;

use App\Models\JadwalPelajaran;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class JadwalSelasaFullSeeder extends Seeder
{
    public function run(): void
    {
        /*--------------------------------------------------------------
        |  1. Petakan urutan kolom → id_kelas                          |
        |-------------------------------------------------------------*/
        $kelasMap = [
            'TAB 10',   // kolom-1
            'TKJ 10',   // kolom-2
            'TAB 11',  // kolom-3
            'TKJ 11',  // kolom-4
            'TAB 12', // kolom-5
            'TKJ 12', // kolom-6
        ];

        /*--------------------------------------------------------------
        |  2. Jadwal per jam_ke (0-9)                                  |
        |  Kosongkan slot yg kuning (Screening, Istirahat, Shalat,     |
        |  Ekstrakurikuler) dengan null/'' agar dilewati.              |
        |-------------------------------------------------------------*/
        $slots = [
            // jam_ke => [kolom-1 , kolom-2 , kolom-3 , kolom-4 , kolom-5 , kolom-6]
            0 => ['',     '',      '',      '',      '',       ''],          // Screening
            1 => ['BI.1', 'BI.1',  'B.JW',  'B.JW',  'TAB',    'TKJ.1'],
            2 => ['BI.1', 'BI.1',  'B.JW',  'B.JW',  'TAB',    'TKJ.1'],
            3 => ['TAB.1','TKJ.2', 'AWJ',   'AWJ',   'B.JW',   'B.JW'],
            4 => ['',     '',      '',      '',      '',       ''],          // Istirahat
            5 => ['PKN',  'PKN',   'TAB.1', 'TKJ',   'AWJ',    'AWJ'],
            6 => ['PKN',  'PKN',   'TAB.1', 'TKJ',   'AWJ',    'AWJ'],
            7 => ['IPAS', 'IPAS',  'BK',    'TKJ.1', 'TAB',    'TKJ'],
            8 => ['',     '',      '',      '',      '',       ''],          // Shalat
            9 => ['',     '',      '',      '',      '',       ''],          // Ekstrakurikuler
        ];

        /*--------------------------------------------------------------
        |  3. Loop & insert                                            |
        |-------------------------------------------------------------*/
        foreach ($kelasMap as $idx => $namaKelas) {

            $kelas = Kelas::where('nama_kelas', $namaKelas)->firstOrFail();
            $col   = $idx;                         // 0..5

            foreach ($slots as $jamKe => $row) {

                $kode = $row[$col] ?? '';

                // lewati slot kosong / kegiatan umum
                if ($kode === '' || $kode === null) continue;

                $mapel = Mapel::where('kode_mapel', $kode)->firstOrFail();

                JadwalPelajaran::firstOrCreate(
                    [
                        'hari'     => 'Selasa',
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
