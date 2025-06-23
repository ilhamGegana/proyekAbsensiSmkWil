<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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
        'reg_code',            // ← kode undangan
        'reg_code_expires',
    ];
    protected $casts = [
        'reg_code_expires' => 'datetime',
    ];
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_walimurid');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_walimurid');
    }
    public function ensureRegCode(int $length = 6): string
    {
        // Jika tidak ada kode atau sudah kedaluwarsa → buat baru
        if (!$this->reg_code || $this->reg_code_expires < now()) {
            $this->reg_code         = strtoupper(Str::random($length));
            $this->reg_code_expires = now()->addDays(30);
            $this->save();
        }
        return $this->reg_code;
    }
}
