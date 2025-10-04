<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique(); // Kode unik untuk tracking order
            $table->foreignId('product_id')->constrained('products'); // Produk yang dibeli
            $table->unsignedBigInteger('total_price'); // Harga total (termasuk fee jika ada)
            
            // Data pelanggan tanpa login
            $table->string('customer_name', 100);
            $table->string('customer_email')->index();
            $table->string('customer_phone', 20)->nullable();

            // Status transaksi
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'completed'])->default('pending');
            $table->string('payment_link')->nullable(); // Link pembayaran dari gateway
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};