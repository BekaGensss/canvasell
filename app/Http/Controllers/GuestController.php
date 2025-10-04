<?php
// app/Http/Controllers/GuestController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\RedeemCode; 

class GuestController extends Controller
{
    /**
     * Tampilkan halaman utama (homepage) dengan daftar produk aktif.
     */
    public function index()
    {
        // PENTING: Menggunakan withCount untuk menghitung stok kode redeem yang 'available'.
        $products = Product::where('is_active', true)
                           ->withCount(['redeemCodes as available_stock' => function ($query) {
                                // Menghitung hanya yang statusnya 'available'
                                $query->where('status', 'available');
                           }])
                           ->get();
        
        return view('frontend.homepage', compact('products'));
    }

    /**
     * Tampilkan detail produk dan form pemesanan tanpa login.
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        
        return view('frontend.product_detail', compact('product'));
    }
}