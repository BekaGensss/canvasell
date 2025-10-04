<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel dasar redeem_codes tanpa relasi ke orders (dibuat di migrasi berikutnya).
     */
    public function up(): void
    {
        Schema::create('redeem_codes', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel products (Tabel products sudah dibuat lebih dulu)
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); 
            
            $table->string('code')->unique(); // Kode redeem unik
            $table->enum('status', ['available', 'used', 'expired'])->default('available'); // Status kode

            // KOLOM order_id dan used_at DITIADAKAN DI SINI, akan ditambahkan di migrasi 163849.
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redeem_codes');
    }
};