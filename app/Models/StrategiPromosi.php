<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrategiPromosi extends Model
{
    use HasFactory;

    protected $table = 'strategi_promosi';

    protected $fillable = [
        'judul',
        'file_path',
        'user_id',
        'deskripsi',
        'kategori',
        'tanggal_kadaluwarsa'
    ];

    // fk user id
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
