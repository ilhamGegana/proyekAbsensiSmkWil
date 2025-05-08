<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Walimurid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Users::with(['siswa', 'guru', 'walimurid'])->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::all();
        $guru = Guru::all();
        $walimurid = Walimurid::all();
        return view('admin.user.create', compact('siswa', 'guru', 'walimurid'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'nullable|exists:siswa,id',
            'id_guru' => 'nullable|exists:guru,id',
            'id_walimurid' => 'nullable|exists:walimurid,id',
            'username' => 'required|string|max:50|unique:user,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,guru,siswa,walimurid',
            'status_aktif' => 'required|boolean',
        ]);

        $requestData = $request->all();
        $requestData['password'] = Hash::make($request->password);

        Users::create($requestData);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
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
    public function edit(Users $user)
    {
        $siswa = Siswa::all();
        $guru = Guru::all();
        $walimurid = Walimurid::all();
        return view('admin.user.edit', compact('user', 'siswa', 'guru', 'walimurid'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $user)
    {
        $request->validate([
            'id_siswa' => 'nullable|exists:siswa,id',
            'id_guru' => 'nullable|exists:guru,id',
            'id_walimurid' => 'nullable|exists:walimurid,id',
            'username' => 'required|string|max:50|unique:user,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,guru,siswa,walimurid',
            'status_aktif' => 'required|boolean',
        ]);

        $user->username = $request->username;
        $user->id_siswa = $request->id_siswa;
        $user->id_guru = $request->id_guru;
        $user->id_walimurid = $request->id_walimurid;
        $user->role = $request->role;
        $user->status_aktif = $request->status_aktif;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}
