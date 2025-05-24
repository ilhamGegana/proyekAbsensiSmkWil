<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $user = User::with(['siswa', 'guru', 'walimurid'])->get();
        $siswa = Siswa::all();
        $guru = Guru::all();
        $walimurid = Walimurid::all();
        return view('admin.user.index', compact('user', 'guru', 'walimurid', 'siswa'));
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
            'username' => 'required|string|max:50|unique:user,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,guru,siswa,walimurid',
            'status_aktif' => 'required|boolean',
            'id_terkait' => 'nullable|integer',
        ]);

        // Cegah duplikasi ID terkait untuk role tertentu
        if ($request->role === 'siswa' && User::where('id_siswa', $request->id_terkait)->exists()) {
            return back()->withErrors(['id_terkait' => 'Siswa ini sudah memiliki akun.'])->withInput();
        }
        if ($request->role === 'guru' && User::where('id_guru', $request->id_terkait)->exists()) {
            return back()->withErrors(['id_terkait' => 'Guru ini sudah memiliki akun.'])->withInput();
        }
        if ($request->role === 'walimurid' && User::where('id_walimurid', $request->id_terkait)->exists()) {
            return back()->withErrors(['id_terkait' => 'Walimurid ini sudah memiliki akun.'])->withInput();
        }

        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->status_aktif = $request->status_aktif;

        // Simpan id_terkait ke kolom sesuai role
        if ($request->role == 'siswa') {
            $user->id_siswa = $request->id_terkait;
        } elseif ($request->role == 'guru') {
            $user->id_guru = $request->id_terkait;
        } elseif ($request->role == 'walimurid') {
            $user->id_walimurid = $request->id_terkait;
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
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
    public function edit(User $user)
    {
        $siswa = Siswa::all();
        $guru = Guru::all();
        $walimurid = Walimurid::all();
        return view('admin.user.edit', compact('user', 'siswa', 'guru', 'walimurid'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Role dan ID terkait tidak diperbolehkan untuk diubah setelah user dibuat
    // Jadi field ini diabaikan meskipun dikirim dari form
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:user,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            // 'role' => 'required|in:admin,guru,siswa,walimurid',
            'status_aktif' => 'required|boolean',
            // 'id_terkait' => 'nullable|integer',
        ]);

        // Cegah duplikasi username manual jika validasi tidak cukup
        if (User::where('username', $request->username)->where('id', '!=', $user->id)->exists()) {
            return back()->withErrors(['username' => 'Username sudah digunakan.'])->withInput();
        }
        
        $user->username = $request->username;
        // $user->role = $request->role;
        $user->status_aktif = $request->status_aktif;

        // Reset semua id_*
        // $user->id_siswa = null;
        // $user->id_guru = null;
        // $user->id_walimurid = null;

        // Simpan sesuai role
        // if ($request->role == 'siswa') {
        //     $user->id_siswa = $request->id_terkait;
        // } elseif ($request->role == 'guru') {
        //     $user->id_guru = $request->id_terkait;
        // } elseif ($request->role == 'walimurid') {
        //     $user->id_walimurid = $request->id_terkait;
        // }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Cek apakah user yang akan dihapus adalah admin
        if ($user->role === 'admin') {
            // Hitung jumlah user admin
            $jumlahAdmin = User::where('role', 'admin')->count();

            // Jika hanya ada 1 admin, tolak penghapusan
            if ($jumlahAdmin <= 1) {
                return redirect()->route('user.index')
                    ->with('error', 'Tidak dapat menghapus user admin terakhir. Harus ada minimal satu admin.');
            }
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }

    public function getTerkait($role)
    {
        if ($role == 'siswa') {
            $data = Siswa::select('id', 'nama_siswa as nama')->get();
        } elseif ($role == 'guru') {
            $data = Guru::select('id', 'nama_guru as nama')->get();
        } elseif ($role == 'walimurid') {
            $data = Walimurid::select('id', 'nama_walimurid as nama')->get();
        } else {
            $data = [];
        }

        return response()->json($data);
    }
}
