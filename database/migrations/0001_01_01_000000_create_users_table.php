<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat struktur tabel di database.
     */
    public function up(): void
    {
        // TABEL USERS (Pengguna)
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama');
            $table->string('username')->unique(); 
            $table->string('email')->unique();    
            $table->string('password');
            $table->enum('role', ['admin', 'tamu'])->default('tamu');
            $table->rememberToken(); 
            $table->timestamps();   
        });

        // TABEL PASSWORD RESET TOKENS
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email menjadi kunci utama
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // TABEL SESSIONS (Penyimpanan Sesi User)
       chema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index(); 
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable(); 
            $table->longText('payload');            
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel jika migration di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};