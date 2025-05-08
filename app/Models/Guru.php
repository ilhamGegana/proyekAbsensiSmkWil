<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nip',
        'nama_guru',
        'telpon_guru',
        'email_guru',
    ];

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id_guru');
    }

    public function user()
    {
        return $this->hasOne(Users::class, 'id_guru');
    }
}

