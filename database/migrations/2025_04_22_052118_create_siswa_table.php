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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 20);
            $table->string('nama_siswa', 100);
            $table->string('signature_data')->nullable();
            $table->char('jenis_kelamin',1);
            $table->date('tgl_lahir')->nullable();
            $table->string('alamat_siswa',255)->nullable();
            $table->string('no_telp_siswa',15)->nullable();
            $table->foreignId('id_kelas')->nullable()->constrained('kelas');
            $table->foreignId('id_walimurid')->nullable()->constrained('walimurid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
