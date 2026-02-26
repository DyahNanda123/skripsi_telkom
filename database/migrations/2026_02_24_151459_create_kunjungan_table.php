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
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('calon_pelanggan_id')->constrained('calon_pelanggan')->onDelete('cascade'); 
            $table->enum('status',['Selesai', 'Progress', 'Follow Up'])->default('Progress');
            $table->text('kesimpulan')->nullable(); 
            $table->string('bukti_foto')->nullable(); // Disimpan dalam bentuk string (path file)
            
            // Data Person In Charge (PIC) atau perwakilan pelanggan
            $table->string('nama_pic')->nullable();
            $table->string('no_hp_pic')->nullable();
            
            // Data Kebutuhan & Eksisting Pelanggan
            $table->string('kebutuhan_utama')->nullable();
            $table->string('speed_eksisting')->nullable(); // Pakai string agar bisa input "100 Mbps"
            $table->string('provider_eksisting')->nullable();
            $table->integer('tagihan_bulanan')->nullable(); // Pakai angka agar mudah dihitung jika perlu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
