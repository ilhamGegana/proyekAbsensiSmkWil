<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walimurid;


class WalimuridController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $walimurid = Walimurid::all();
        return view('admin.walimurid.index', compact('walimurid'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.walimurid.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_walimurid' => 'required',
            'telpon_walimurid' => 'nullable|max:15',
            'email_walimurid' => 'nullable|email',
            'alamat_walimurid' => 'nullable',
        ]);

        Walimurid::create($request->all());
        return redirect()->route('admin.walimurid.index')->with('success', 'Data berhasil ditambahkan');
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
    public function edit(Walimurid $walimurid)
    {
        return view('admin.walimurid.edit', compact('walimurid'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Walimurid $walimurid)
    {
        $request->validate([
            'nama_walimurid' => 'required',
            'telpon_walimurid' => 'nullable|max:15',
            'email_walimurid' => 'nullable|email',
            'alamat_walimurid' => 'nullable',
        ]);

        $walimurid->update($request->all());
        return redirect()->route('admin.walimurid.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Walimurid $walimurid)
    {
        $walimurid->delete();
        return redirect()->route('admin.walimurid.index')->with('success', 'Data berhasil dihapus');
    }
}
