<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ingat, pakai Schema::table (bukan create) karena kita mau modifikasi yang sudah ada
        Schema::table('strategi_promosi', function (Blueprint $table) {
            $table->date('tanggal_kadaluwarsa')->after('kategori')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('strategi_promosi', function (Blueprint $table) {
            $table->dropColumn('tanggal_kadaluwarsa');
        });
    }
};