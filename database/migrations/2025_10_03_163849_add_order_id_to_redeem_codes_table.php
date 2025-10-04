<?php
// database/migrations/2025_10_03_163849_add_order_id_to_redeem_codes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Logika: Hanya menambahkan kolom order_id. Kolom used_at diasumsikan sudah ada.
     */
    public function up(): void
    {
        Schema::table('redeem_codes', function (Blueprint $table) {
            
            // Tambahkan Foreign Key ke tabel 'orders'
            $table->foreignId('order_id')
                  ->nullable()
                  ->constrained('orders')
                  ->onDelete('set null')
                  ->after('status');

            // Baris penambahan used_at DITIADAKAN di sini untuk menghindari error "Duplicate column name".
        });
    }

    /**
     * Reverse the migrations.
     * Logika: Menghapus kolom order_id saat rollback.
     */
    public function down(): void
    {
        Schema::table('redeem_codes', function (Blueprint $table) {
            $table->dropForeign(['order_id']); 
            $table->dropColumn('order_id');
            
            // dropColumn untuk used_at DITIADAKAN, karena kolom itu dibuat di migrasi lain.
        });
    }
};