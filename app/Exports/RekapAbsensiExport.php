<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapAbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return ['Nama Siswa', 'Kelas', 'Alpha', 'Sakit', 'Izin'];
    }

    public function map($siswa): array
    {
        return [
            $siswa->nama_siswa,
            $siswa->kelas->nama_kelas ?? '-',
            $siswa->alpha_count ?? 0,
            $siswa->sakit_count ?? 0,
            $siswa->izin_count ?? 0,
        ];
    }
}
