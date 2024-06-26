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
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom created_at dan updated_at
            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
            $table->dropTimestamps();
            
            // Tambah kolom
            $table->string('nip', 10);
            $table->string('nomor_telepon', 20)->nullable();
            $table->string('alamat', 120)->nullable();
            $table->string('role', 50)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->Timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 
        });
    }
};