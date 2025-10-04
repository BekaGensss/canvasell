<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Proteksi Mass Assignment: field yang boleh diisi melalui input user
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'is_active',
    ];

    // Relasi: Satu Produk memiliki banyak Kode Redeem
    public function redeemCodes()
    {
        return $this->hasMany(RedeemCode::class);
    }
}