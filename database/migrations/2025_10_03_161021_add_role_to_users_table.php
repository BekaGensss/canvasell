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
        // Memastikan tabel 'users' ada sebelum menambahkan kolom
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Tambahkan kolom 'role' dengan tipe ENUM ('admin', 'user'), 
                // nilai default 'user', diletakkan setelah kolom 'email'.
                // Kami juga mengecek apakah kolom 'role' sudah ada sebelum menambahkannya
                if (!Schema::hasColumn('users', 'role')) {
                    $table->enum('role', ['admin', 'user'])->default('user')->after('email');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Memastikan tabel 'users' ada sebelum menghapus kolom
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Hapus kolom 'role'. 
                // Kami juga mengecek apakah kolom 'role' ada sebelum menghapusnya
                if (Schema::hasColumn('users', 'role')) {
                    $table->dropColumn('role');
                }
            });
        }
    }
};