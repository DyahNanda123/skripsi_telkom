<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // Menampilkan halaman form edit profil
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Edit Profil Saya'
        ];
        $activeMenu = 'profile';

        return view('profile', compact('breadcrumb', 'activeMenu'));
    }

    // Memproses data yang diubah
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        // Validasi semua data yang diinput
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'nomor_hp'      => 'nullable|string|max:20',
            'wilayah_kerja' => 'nullable|string|max:100',
            'alamat'        => 'nullable|string',
            'foto_profil'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
            'password'      => 'nullable|min:8', 
        ]);

        // Update data teks
        $user->nama_lengkap  = $request->nama_lengkap;
        $user->email         = $request->email;
        $user->nomor_hp      = $request->nomor_hp;
        $user->wilayah_kerja = $request->wilayah_kerja;
        $user->alamat        = $request->alamat;

        // Jika user mengisi password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Jika user mengunggah foto baru
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && file_exists(storage_path('app/public/' . $user->foto_profil))) {
                unlink(storage_path('app/public/' . $user->foto_profil));
            }
            // Simpan foto baru ke folder public/storage/profil
            $path = $request->file('foto_profil')->store('profil', 'public');
            $user->foto_profil = $path;
        }

        $user->save();

        return back()->with('success', 'Profil dan foto berhasil diperbarui!');
    }
}