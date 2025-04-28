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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas',50);
            $table->unsignedTinyInteger('tingkat');
            $table->foreignId('id_guru')->nullable()->constrained('guru');
            $table->timestamps();
            // Untuk mencegah duplikasi kombinasi
            $table->unique(['nama_kelas', 'tingkat'], 'kelas_nama_tingkat_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
