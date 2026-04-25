<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Halaman login
    public function index()
    {
        return view('login');
    }

    // Proses login
    public function authenticate(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'password' => 'required'
        ]);

        // cek user berdasarkan NIP dulu
        $user = User::where('nip', $request->nip)->first();

        if (!$user) {
            return back()->with('error', 'NIP tidak terdaftar!');
        }

        // cek status aktif
        if ($user->status_aktif == 0) {
            return back()->with('error', 'Akun Anda tidak aktif!');
        }

        // cek password
        if (Auth::attempt([
            'nip' => $request->nip,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('error', 'Password salah!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}