<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Walimurid;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::with('kelas')->get();
        $kelas = Kelas::all();
        $walimurid = Walimurid::all();
        return view('admin.siswa.index', compact('siswa', 'kelas', 'walimurid'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        $walimurid = Walimurid::all();
        return view('admin.siswa.create', compact('kelas', 'walimurid'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis|max:20',
            'nama_siswa' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'nullable|date',
            'alamat_siswa' => 'nullable|max:255',
            'no_telp_siswa' => 'nullable|max:15',
            'id_kelas' => 'nullable|exists:kelas,id',
            'id_walimurid' => 'nullable|exists:walimurid,id',
            'signature_data' => 'nullable|string',
        ]);

        Siswa::create($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
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
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        $walimurid = Walimurid::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas', 'walimurid'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|max:20|unique:siswa,nis,' . $siswa->id,
            'nama_siswa' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'nullable|date',
            'alamat_siswa' => 'nullable|max:255',
            'no_telp_siswa' => 'nullable|max:15',
            'id_kelas' => 'nullable|exists:kelas,id',
            'id_walimurid' => 'nullable|exists:walimurid,id',
            'signature_data' => 'nullable|string',
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        // Cek apakah siswa punya akun user
        if ($siswa->user()->exists()) {
            return redirect()->route('siswa.index')
                ->with('error', 'Gagal menghapus: Siswa masih memiliki akun user.');
        }

        // Cek apakah siswa memiliki absensi
        if ($siswa->absensi()->exists()) {
            return redirect()->route('siswa.index')
                ->with('error', 'Gagal menghapus: Siswa masih memiliki data absensi.');
        }

        // Cek apakah siswa memiliki notifikasi
        if ($siswa->notifikasi()->exists()) {
            return redirect()->route('siswa.index')
                ->with('error', 'Gagal menghapus: Siswa masih memiliki notifikasi yang dikirim atau diterima.');
        }

        // Jika tidak ada relasi aktif, hapus siswa
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
