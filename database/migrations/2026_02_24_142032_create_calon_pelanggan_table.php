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
        Schema::create('calon_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jenis_pelanggan', ['Agrikultur', 'Energi', 'Sekolah', 'Ekspedisi', 'Manufaktur', 'Puskesmas/RS', 'SPPG', 'Media & Komunikasi', 'Multifinance', 'Properti', 'Hotel', 'Ruko']);
            $table->text('link_maps')->nullable();
            $table->enum('status_langganan',['Berlangganan', 'Belum Berlangganan'])->default('Belum Berlangganan');
            $table->enum('status_visit',['Sudah Visit', 'Belum Visit', 'Progress'])->default('Belum Visit');
            $table->enum('wilayah',['Magetan', 'Ngawi']);
            $table->enum('sto',['GGR', 'JGO', 'KRJ', 'MGT', 'NWI', 'SAR', 'WKU']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_pelanggan');
    }
};
