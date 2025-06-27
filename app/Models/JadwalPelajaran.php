<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalPelajaran extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'jadwal_pelajaran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'hari',
        'jam_ke',
        'id_guru',
        'id_mapel',
        'id_kelas',
        'is_active'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_jadwal');
    }
    public function scopeAktif($q)
    {
        return $q->where('is_active', true);
    }
}
