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
        Schema::table('messages', function (Blueprint $table) {
            // Cek jika kolomnya ada sebelum mencoba menghapusnya
            if (Schema::hasColumn('messages', 'receiver_id')) {
                
                // 1. Hapus foreign key constraint-nya dulu (jika ada)
                // Kita harus tahu nama constraint-nya, atau coba cara ini
                try {
                    // Coba hapus constraint jika ada
                    $table->dropForeign(['receiver_id']);
                } catch (\Exception $e) {
                    // Tidak masalah jika gagal, berarti constraint-nya tidak ada
                }

                // 2. Hapus kolomnya
                $table->dropColumn('receiver_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     * (Untuk berjaga-jaga jika kita perlu mengembalikan)
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // (Pastikan Anda mengarah ke tabel 'users' yang benar)
            $table->foreignId('receiver_id')->nullable()->constrained('users');
        });
    }
};