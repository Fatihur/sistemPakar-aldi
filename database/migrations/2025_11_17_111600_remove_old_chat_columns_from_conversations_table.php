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
        Schema::table('conversations', function (Blueprint $table) {
            // 1. Hapus foreign key constraint-nya dulu
            // (Laravel akan otomatis mencari nama constraint berdasarkan nama kolom)
            $table->dropForeign(['farmer_id']);
            $table->dropForeign(['expert_id']);

            // 2. Hapus kolomnya
            $table->dropColumn(['farmer_id', 'expert_id']);
        });
    }

    /**
     * Reverse the migrations.
     * (Untuk berjaga-jaga jika kita perlu mengembalikan)
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            // (Pastikan Anda mengarah ke tabel 'users' yang benar)
            $table->foreignId('farmer_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('expert_id')->nullable()->constrained('users')->onDelete('cascade');
        });
    }
};