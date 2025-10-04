<?php
// app/Models/RedeemCode.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'code',
        'status',
        'order_id',
        'used_at',
    ];

    // === TAMBAHKAN INI UNTUK CASTING TANGGAL ===
    protected $casts = [
        'used_at' => 'datetime',
    ];
    // ===========================================

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}