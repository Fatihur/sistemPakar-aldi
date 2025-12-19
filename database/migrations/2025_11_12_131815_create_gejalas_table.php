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
        Schema::create('gejalas', function (Blueprint $table) {
            $table->id(); // Kunci primer (1, 2, 3...)
            $table->string('kode', 10)->unique(); // Untuk 'G01', 'G02', dll.
            $table->text('gejala'); // Untuk deskripsi gejala yang panjang
            $table->string('bagian', 100)->nullable();
            $table->timestamps(); // Menambahkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gejalas', function (Blueprint $table) {
            $table->dropColumn('bagian');
        });
    }
};