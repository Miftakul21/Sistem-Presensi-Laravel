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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // Tambah kolom
            $table->string('nip', 10);
            $table->string('nomor_telepon', 20)->nullable();
            $table->string('alamat', 120)->nullable();
            $table->string('role', 50)->nullable();
            $table->string('divisi', 100)->nullable();
            $table->rememberToken();

            // Foreign key location id
            // $table->foreign('id_location')->references('id')->on('location')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};