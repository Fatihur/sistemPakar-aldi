<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyakit_solusi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyakit_id')->constrained('penyakits')->onDelete('cascade');
            $table->foreignId('solusi_id')->constrained('solusis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyakit_solusi');
    }
};