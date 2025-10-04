<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Properti yang diizinkan untuk mass assignment (Kolom Data)
    protected $fillable = [
        'order_code',
        'product_id',
        'total_price',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status', 
        'payment_link',
        'payment_method',
    ];

    // Casting: Mengubah kolom database menjadi tipe data PHP/Carbon object
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi: Satu Order memiliki satu Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Satu Order memiliki satu Kode Redeem
    public function redeemCode()
    {
        // Order memiliki SATU kode redeem
        return $this->hasOne(RedeemCode::class);
    }
}