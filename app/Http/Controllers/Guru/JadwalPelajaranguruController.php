<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPelajaranguruController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;

        // Ambil semua jadwal guru, urutkan berdasarkan jam ke dan hari
        $jadwalpelajaran = JadwalPelajaran::where('id_guru', $guru->id)
            ->orderBy('jam_ke')
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->with(['mapel', 'kelas'])
            ->get();

        // Kelompokkan data berdasarkan jam ke dan kelas
        $grouped = [];
        foreach ($jadwalpelajaran as $jadwal) {
            $jam = $jadwal->jam_ke;
            $kelas = $jadwal->kelas->nama_kelas ?? 'Tanpa Kelas';
            $grouped[$jam][$kelas][$jadwal->hari] = $jadwal->mapel->nama_mapel ?? '-';
        }

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('guru.jadwalpelajaran.index', compact('grouped', 'hariList'));
    }
}
