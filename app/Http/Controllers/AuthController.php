<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\WaliMurid;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'guru'  => redirect()->intended('/guru/home'),
                'admin' => redirect()->intended('/admin/dashboard'),
                'siswa' => redirect()->intended('/siswa/home'),
                'walimurid' => redirect()->intended('/walimurid/home'),
                default => redirect()->intended('/'),
            };
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.'
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $role       = $request->role;
        $identifier = $request->identifier;

        /* ── Temukan baris master sesuai role ── */
        $row = match ($role) {
            'siswa'     => Siswa::where('nis', $identifier)->first(),
            'guru'      => Guru::where('nip', $identifier)->first(),
            'walimurid' => WaliMurid::where('telpon_walimurid', $identifier)
                ->orWhere('reg_code', $identifier)
                ->first(),
        };

        if (!$row) {
            return back()->withErrors('Data master tidak ditemukan. Hubungi admin.');
        }

        if ($row->user) {
            return back()->withErrors('Akun sudah terdaftar, silakan login.');
        }

        /* ── Buat user ── */
        $user = User::create([
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            "id_{$role}"    => $row->id,   // id_siswa / id_guru / id_walimurid
            'role'          => $role,
            'status_aktif'  => 1,
        ]);

        /* ── Untuk wali, habiskan kode ── */
        if ($role === 'walimurid' && $identifier === $row->reg_code) {
            $row->update(['reg_code' => null, 'reg_code_expires' => null]);
        }

        Auth::login($user);
        return redirect()->intended('/login')->with('success','Registrasi berhasil, silakan login');;
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success','Anda Keluar dari Akun');;
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
}
