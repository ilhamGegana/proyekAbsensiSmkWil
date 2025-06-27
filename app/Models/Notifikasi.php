<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifikasi extends Model
{
    use HasFactory;
    protected $casts = [
        'response'    => 'array',     // JSON → array otomatis
        'waktu_kirim' => 'datetime',  // bantu parsing & format
    ];
    protected $table = 'notifikasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_guru',
        'id_siswa',
        'pesan',
        'waktu_kirim',
        'tujuan',
        'response',
        'status_kirim'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
