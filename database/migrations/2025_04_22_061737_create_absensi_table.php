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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswa');
            $table->foreignId('id_jadwal')->constrained('jadwal_pelajaran');
            $table->string('signature_ref')->nullable();
            $table->string('status_absen', 10);
            $table->timestamp('tgl_waktu_absen')->useCurrent();
            $table->string('keterangan',255)->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
