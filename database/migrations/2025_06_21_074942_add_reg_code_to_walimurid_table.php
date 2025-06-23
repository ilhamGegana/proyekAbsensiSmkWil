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
        Schema::table('walimurid', function (Blueprint $table) {
            // kode undangan 6–8 karakter, nullable sampai digenerate
            $table->string('reg_code', 8)
                  ->nullable()
                  ->unique()
                  ->after('alamat_walimurid');

            // masa berlaku kode (opsional, bisa null berarti tidak kedaluwarsa)
            $table->timestamp('reg_code_expires')
                  ->nullable()
                  ->after('reg_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('walimurid', function (Blueprint $table) {
            $table->dropColumn(['reg_code', 'reg_code_expires']);
        });
    }
};
