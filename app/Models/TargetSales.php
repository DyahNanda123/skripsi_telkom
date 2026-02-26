<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetSales extends Model
{
    use HasFactory;

    protected $table = 'target_sales';

    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'jumlah_target',
    ];

    // fk user_id 
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
