<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ===============================================
// Imports Frontend
// ===============================================
use App\Http\Controllers\GuestController;
use App\Http\Controllers\OrderController; // FRONTEND OrderController

// ===============================================
// Imports Admin (Final & Korek)
// ===============================================
use App\Http\Controllers\Admin\DashboardController; 
use App\Http\Controllers\Admin\ProductController; 
use App\Http\Controllers\Admin\RedeemCodeController; 
use App\Http\Controllers\Admin\OrderManagementController; // KELAS ADMIN ORDER RESMI


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🛑 SOLUSI DARURAT UNTUK MENGATASI HARDCODE 'dashboard' 🛑
Route::get('/dashboard', function() {
    // Cek apakah pengguna sudah login dan merupakan Admin
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    // Default redirect jika ada user biasa yang ter-login
    return redirect()->route('homepage'); 
})->middleware(['auth'])->name('dashboard');

// ===============================================
// RUTE FRONTEND (TANPA LOGIN) - TOKO ONLINE
// ===============================================

// Halaman Utama: Daftar Produk
Route::get('/', [GuestController::class, 'index'])->name('homepage');

// Detail Produk dan Mulai Checkout
Route::get('/product/{product}', [GuestController::class, 'show'])->name('product.show');

// Proses Checkout (Membuat Order)
Route::post('/order/create', [OrderController::class, 'store'])->name('order.store');

// Halaman Konfirmasi dan Pembayaran
Route::get('/order/{order_code}', [OrderController::class, 'show'])->name('order.show');

// Webhook Pembayaran 
Route::post('/payment/webhook', [OrderController::class, 'webhook'])->name('payment.webhook');


// ===============================================
// RUTE BAWAAN LARAVEL BREEZE (UNTUK ADMIN SAJA)
// ===============================================

// PERBAIKAN: AKTIFKAN KEMBALI ROUTE PROFILE UNTUK MENGHILANGKAN ERROR profile.edit NOT FOUND
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ===============================================
// RUTE PANEL ADMIN (DIPROTEKSI)
// ===============================================
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Rute Dashboard Admin: /admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Rute CRUD Produk 
    Route::resource('products', ProductController::class);

    // Rute CRUD Kode Redeem
    Route::resource('redeem-codes', RedeemCodeController::class)->except(['show']);
    Route::get('redeem-codes/import', [RedeemCodeController::class, 'importForm'])->name('redeem-codes.import.form');
    Route::post('redeem-codes/import', [RedeemCodeController::class, 'importStore'])->name('redeem-codes.import.store');
    
    // Rute Pemesanan
    Route::post('orders/clear-history', [OrderManagementController::class, 'clearHistory'])->name('orders.clear-history'); // 🛑 Rute Hapus Massal
    Route::resource('orders', OrderManagementController::class)->only(['index', 'show', 'destroy']); // Rute Resource

});

require __DIR__.'/auth.php';