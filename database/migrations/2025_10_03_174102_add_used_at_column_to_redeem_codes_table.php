<?php
// database/migrations/YYYY_MM_DD_XXXXXX_add_used_at_column_to_redeem_codes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('redeem_codes', function (Blueprint $table) {
            // TAMBAHKAN KOLOM used_at YANG HILANG
            $table->timestamp('used_at')->nullable()->after('order_id');
        });
    }

    public function down(): void
    {
        Schema::table('redeem_codes', function (Blueprint $table) {
            $table->dropColumn('used_at');
        });
    }
};