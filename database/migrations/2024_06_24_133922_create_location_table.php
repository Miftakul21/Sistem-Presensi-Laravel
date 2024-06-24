<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('location', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('tipe', ['pusat', 'cabang']);
            $table->string('latitude');
            $table->string('longtitude');
            $table->integer('radius');
            $table->enum('zona_waktu', ['WIB', 'WITA', 'WIT']);
            $table->string('jam_masuk', 30);
            $table->string('jam_keluar', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location');
    }
};