<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Models\Guru;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapel = Mapel::with('guru')->get();
        $guru  = Guru::orderBy('nama_guru')->get();
        return view('admin.mapel.index', compact('mapel', 'guru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => ['required', 'string', 'max:100'],
            'kode_mapel' => ['nullable', 'string', 'max:20', 'unique:mapel,kode_mapel'],
            'id_guru'    => ['nullable', 'exists:guru,id'],
        ]);

        // hanya kolom yang diterima fillable
        Mapel::create(
            $request->only(['nama_mapel', 'kode_mapel', 'id_guru'])
        );

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
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
    public function edit(Mapel $mapel)
    {
        $guru = Guru::orderBy('nama_guru')->get();

        return view('admin.mapel.edit', compact('mapel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'nama_mapel' => ['required', 'string', 'max:100'],
            'kode_mapel' => [
                'nullable',
                'string',
                'max:20',
                'unique:mapel,kode_mapel,' . $mapel->id,
            ],
            'id_guru' => ['nullable', 'exists:guru,id'],
        ]);

        $mapel->update(
            $request->only(['nama_mapel', 'kode_mapel', 'id_guru'])
        );

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return redirect()->route('mapel.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
