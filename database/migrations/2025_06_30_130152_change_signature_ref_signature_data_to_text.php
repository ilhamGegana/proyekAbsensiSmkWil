<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Ubah kolom signature_data pada tabel siswa
        Schema::table('siswa', function (Blueprint $table) {
            $table->text('signature_data')->nullable()->change();
        });

        // Ubah kolom signature_ref pada tabel absensi
        Schema::table('absensi', function (Blueprint $table) {
            $table->text('signature_ref')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Kembalikan ke string jika dibutuhkan
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('signature_data')->nullable()->change();
        });

        Schema::table('absensi', function (Blueprint $table) {
            $table->string('signature_ref')->nullable()->change();
        });
    }
};
