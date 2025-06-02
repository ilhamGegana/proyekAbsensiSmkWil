<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;

class JadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwalPelajaran = JadwalPelajaran::with(['guru', 'mapel', 'kelas'])->get();
        $guru = Guru::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        return view('admin.jadwalPelajaran.index', compact('jadwalPelajaran', 'guru', 'mapel', 'kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = Guru::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        return view('admin.jadwalPelajaran.create', compact('guru', 'mapel', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|max:20',
            'id_guru' => 'required|exists:guru,id',
            'id_mapel' => 'required|exists:mapel,id',
            'id_kelas' => 'required|exists:kelas,id',
        ]);

        JadwalPelajaran::create($request->all());

        return redirect()->route('jadwalPelajaran.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        $guru = Guru::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        return view('admin.jadwalPelajaran.edit', compact('jadwalPelajaran', 'guru', 'mapel', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        $request->validate([
            'hari' => 'required|max:20',
            'id_guru' => 'required|exists:guru,id',
            'id_mapel' => 'required|exists:mapel,id',
            'id_kelas' => 'required|exists:kelas,id',
        ]);

        $jadwalPelajaran->update($request->all());

        return redirect()->route('jadwalPelajaran.index')->with('success', 'Jadwal pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        if ($jadwalPelajaran->absensi()->exists()) {
            return back()->with('error', 'Jadwal sudah digunakan di absensi.');
        }

        $jadwalPelajaran->delete();
        return back()->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }
}
