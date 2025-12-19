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
        Schema::create('conversation_participant', function (Blueprint $table) {
            $table->id();
            
            // Kunci asing untuk percakapan
            $table->foreignId('conversation_id')
                  ->constrained('conversations')
                  ->onDelete('cascade'); // Jika percakapan dihapus, baris ini ikut terhapus

            // Kunci asing untuk pengguna (petani atau pakar)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade'); // Jika user dihapus, baris ini ikut terhapus
            
            $table->timestamps();

            // Opsional: Pastikan satu pengguna tidak bisa bergabung
            // ke percakapan yang sama lebih dari sekali
            $table->unique(['conversation_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversation_participant');
    }
};