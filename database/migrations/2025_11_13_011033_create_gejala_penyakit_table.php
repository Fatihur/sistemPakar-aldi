<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ini adalah tabel PIVOT untuk relasi Many-to-Many
        Schema::create('gejala_penyakit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gejala_id')->constrained('gejalas')->onDelete('cascade');
            $table->foreignId('penyakit_id')->constrained('penyakits')->onDelete('cascade');
            
            // Opsional: tambahkan bobot/nilai CF (Certainty Factor) di sini jika perlu
            // $table->float('bobot')->default(1.0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gejala_penyakit');
    }
};