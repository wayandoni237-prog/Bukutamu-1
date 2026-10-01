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

            // Hapus kolom nik
            if (Schema::hasColumn('users', 'nik')) {
                $table->dropColumn('nik');
            }

            // Tambah kolom email
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->after('username');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Hapus email jika rollback
            if (Schema::hasColumn('users', 'email')) {
                $table->dropColumn('email');
            }

            // Kembalikan nik jika rollback
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik')->after('username');
            }

        });
    }
};