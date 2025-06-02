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
        Schema::create('walimurid', function (Blueprint $table) {
            $table->id();
            $table->string('nama_walimurid', 100);
            $table->string('telpon_walimurid', 15)->nullable();
            $table->string('email_walimurid', 100)->nullable();
            $table->string('alamat_walimurid', 225)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walimurid');
    }
};
