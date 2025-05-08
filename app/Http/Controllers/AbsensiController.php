<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\JadwalPelajaran;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absensi = Absensi::with(['siswa', 'jadwal'])->get();
        return view('admin.absensi.index', compact('absensi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::all();
        $jadwal = JadwalPelajaran::all();
        return view('admin.absensi.create', compact('siswa', 'jadwal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id',
            'id_jadwal' => 'required|exists:jadwal_pelajaran,id',
            'status_absen' => 'required|max:10',
            'keterangan' => 'nullable|max:255',
            'signature_ref' => 'nullable|string',
        ]);

        Absensi::create($request->all());

        return redirect()->route('admin.absensi.index')->with('success', 'Data absensi berhasil ditambahkan.');
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
    public function edit(Absensi $absensi)
    {
        $siswa = Siswa::all();
        $jadwal = JadwalPelajaran::all();
        return view('admin.absensi.edit', compact('absensi', 'siswa', 'jadwal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id',
            'id_jadwal' => 'required|exists:jadwal_pelajaran,id',
            'status_absen' => 'required|max:10',
            'keterangan' => 'nullable|max:255',
            'signature_ref' => 'nullable|string',
        ]);

        $absensi->update($request->all());

        return redirect()->route('admin.absensi.index')->with('success', 'Data absensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return redirect()->route('admin.absensi.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}
