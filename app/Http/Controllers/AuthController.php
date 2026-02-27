<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function index() {
        return view('login'); 
    }

    // Mengecek proses login
    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'nip' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Kalau sukses, lempar ke Dashboard
        }

        // Kalau gagal, kembalikan ke halaman login bawa pesan error
        return back()->with('error', 'NIP atau Password salah!');
    }

    // Proses logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}