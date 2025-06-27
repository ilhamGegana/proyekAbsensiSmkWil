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
        Schema::table('mapel', function (Blueprint $table) {
            // kolom kode_mapel
            $table->string('kode_mapel', 20)
                ->after('id')
                ->unique()
                ->nullable();

            // relasi ke tabel guru
            $table->foreignId('id_guru')
                ->nullable()
                ->after('kode_mapel')
                ->constrained('guru', 'id')
                ->nullOnDelete();    // saat guru di-delete, set kolom ini ke NULL
        });
    }

    public function down(): void
    {
        Schema::table('mapel', function (Blueprint $table) {
            // urutan: hapus FK → hapus kolom
            $table->dropForeign(['id_guru']);
            $table->dropColumn(['kode_mapel', 'id_guru']);
        });
    }
};
