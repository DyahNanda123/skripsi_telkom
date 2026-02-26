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
        Schema::create('strategi_promosi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('file_path'); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->text('deskripsi')->nullable(); 
            $table->enum('kategori', ['brosur', 'poster', 'video', 'presentasi', 'lainnya']); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strategi_promosi');
    }
};
