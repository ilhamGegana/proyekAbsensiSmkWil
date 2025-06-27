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
        Schema::table('notifikasi', function (Blueprint $table) {
            // ubah status_kirim jadi enum
            $table->enum('status_kirim', ['pending', 'sent', 'failed'])
                ->default('pending')
                ->change();

            // jadikan waktu_kirim nullable
            $table->dateTime('waktu_kirim')->nullable()->change();

            // kolom response untuk payload Fonnte
            $table->json('response')->nullable()->after('status_kirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->boolean('status_kirim')->default(false)->change();
            $table->dateTime('waktu_kirim')->nullable(false)->change();
            $table->dropColumn('response');
        });
    }
};
