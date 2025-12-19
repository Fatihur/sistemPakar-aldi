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
        Schema::table('penyakits', function (Blueprint $table) {
            // Menambahkan kolom bobot/P(c) setelah kolom 'gambar'
            // Angka 15, 14 berarti presisi tinggi untuk menyimpan nilai desimal Anda
            $table->float('p_c', 15,   )->nullable()->after('gambar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penyakits', function (Blueprint $table) {
            $table->dropColumn('p_c');
        });
    }
};