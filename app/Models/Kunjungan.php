<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';

    protected $fillable = [
        'user_id',
        'calon_pelanggan_id',
        'status',
        'kesimpulan',
        'bukti_foto',
        'nama_pic',
        'no_hp_pic',
        'kebutuhan_utama',
        'speed_eksisting',
        'provider_eksisting',
        'tagihan_bulanan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function calonPelanggan()
    {
        return $this->belongsTo(CalonPelanggan::class, 'calon_pelanggan_id');
    }
}