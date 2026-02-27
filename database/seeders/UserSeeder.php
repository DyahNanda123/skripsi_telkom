<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan model User dipanggil

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama_lengkap' => 'Admin Telkom Ngawi',
            'nip' => '123456',
            'password'     => Hash::make('telkom123'), // Passwordnya: telkom123
            'role'         => 'admin',
            'wilayah_kerja' => 'Magetan',
        ]);
    }
}