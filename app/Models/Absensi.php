<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_siswa',
        'id_jadwal',
        'signature_ref',
        'status_absen',
        'tgl_waktu_absen',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'id_jadwal');
    }
}