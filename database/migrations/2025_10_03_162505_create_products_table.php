<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_products_table.php

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Nama produk, wajib diisi
            $table->text('description')->nullable(); // Deskripsi lengkap
            $table->unsignedBigInteger('price'); // Harga dalam Rupiah (gunakan unsignedBigInteger untuk menghindari float)
            $table->string('image')->nullable(); // Path gambar produk (misalnya: storage/images/canva_pro.png)
            $table->boolean('is_active')->default(true); // Status: untuk mengaktifkan/menonaktifkan produk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};