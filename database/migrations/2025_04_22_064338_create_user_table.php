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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->nullable()->constrained('siswa');
            $table->foreignId('id_guru')->nullable()->constrained('guru');
            $table->foreignId('id_walimurid')->nullable()->constrained('walimurid');
            $table->string('username', 50)->unique();
            $table->string('password',100);
            $table->enum('role', ['admin', 'guru', 'siswa', 'walimurid']);
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
