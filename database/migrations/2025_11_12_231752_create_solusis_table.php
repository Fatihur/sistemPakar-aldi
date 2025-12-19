<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solusis', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // Untuk 'KO1', 'KO2', dll.
            $table->string('nama_obat'); // Untuk 'Score', 'Amistartop', dll.
            $table->string('gambar_obat')->nullable(); // Path ke gambar obat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solusis');
    }
};