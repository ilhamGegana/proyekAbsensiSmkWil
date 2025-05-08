<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaliMurid extends Model
{
    use HasFactory;

    protected $table = 'walimurid';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_walimurid',
        'telpon_walimurid',
        'email_walimurid',
        'alamat_walimurid',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_walimurid');
    }

    public function user()
    {
        return $this->hasOne(Users::class, 'id_walimurid');
    }
}
