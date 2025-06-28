<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        return ['Nama Siswa', 'Kelas', 'Tanggal', 'Jam Pelajaran', 'Status'];
    }

    public function map($absensi): array
    {
        return [
            $absensi->siswa->nama_siswa ?? '-',
            $absensi->siswa->kelas->nama_kelas ?? '-',
            \Carbon\Carbon::parse($absensi->tgl_waktu_absen)->format('d/m/Y'),
            $absensi->jadwal->jam_ke ?? '-',
            ucfirst($absensi->status_absen),
        ];
    }
}