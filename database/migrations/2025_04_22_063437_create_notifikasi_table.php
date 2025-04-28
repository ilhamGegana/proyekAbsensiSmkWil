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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_guru')->nullable()->constrained('guru');
            $table->foreignId('id_siswa')->nullable()->constrained('siswa');
            $table->text('pesan')->nullable();
            $table->dateTime('waktu_kirim');
            $table->string('tujuan',50);
            $table->boolean('status_kirim')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
