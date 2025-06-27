<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_mapel',
        'kode_mapel',
        'id_guru',
    ];

    public function jadwal()
    {
        return $this->hasMany(JadwalPelajaran::class, 'id_mapel');
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}