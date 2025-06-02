<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nis',
        'nama_siswa',
        'signature_data',
        'jenis_kelamin',
        'tgl_lahir',
        'alamat_siswa',
        'no_telp_siswa',
        'id_kelas',
        'id_walimurid',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_siswa');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function walimurid()
    {
        return $this->belongsTo(Walimurid::class, 'id_walimurid');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_siswa');
    }
}
