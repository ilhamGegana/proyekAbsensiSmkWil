<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('signature_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('threshold')->default(75); // default awal
            $table->timestamps();
        });

        // Masukkan default data awal
        DB::table('signature_settings')->insert([
            'threshold' => 75,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signature_settings');
    }
};
