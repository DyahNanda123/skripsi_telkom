<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonPelanggan extends Model
{
    use HasFactory;

    // nama tabel asli 
    protected $table = 'calon_pelanggan';

    // kolom yg boleh diisi
    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'jenis_pelanggan',
        'link_maps',
        'status_langganan',
        'status_visit',
        'wilayah',
        'sto',
    ];
}
