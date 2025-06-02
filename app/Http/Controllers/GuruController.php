<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::all();
        return view('admin.guru.index', compact('guru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'nullable|max:20|unique:guru,nip',
            'nama_guru' => 'required|max:100',
            'telpon_guru' => 'nullable|max:15',
            'email_guru' => 'nullable|email|max:100',
        ]);

        Guru::create($request->all());

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
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
    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => 'nullable|max:20|unique:guru,nip,' . $guru->id,
            'nama_guru' => 'required|max:100',
            'telpon_guru' => 'nullable|max:15',
            'email_guru' => 'nullable|email|max:100',
        ]);

        $guru->update($request->all());

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        // Cek apakah guru memiliki akun user
        if ($guru->user()->exists()) {
            return redirect()->route('guru.index')
                ->with('error', 'Gagal menghapus: Guru masih memiliki akun user.');
        }

        // Cek apakah guru menjadi wali kelas
        if ($guru->kelas()->exists()) {
            return redirect()->route('guru.index')
                ->with('error', 'Gagal menghapus: Guru masih menjadi wali kelas.');
        }

        // Cek apakah guru memiliki jadwal pelajaran
        if ($guru->jadwal()->exists()) {
            return redirect()->route('guru.index')
                ->with('error', 'Gagal menghapus: Guru masih memiliki jadwal pelajaran.');
        }

        // Jika tidak ada relasi aktif, hapus guru
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
