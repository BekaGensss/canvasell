<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // Diperlukan untuk Blade::if

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🛑 DEFINISI BLADE DIRECTIVE KHUSUS ADMIN 🛑
        // Directive ini akan mengamankan link di navigation.blade.php
        Blade::if('admin', function () {
            // Asumsi: Kolom 'role' ada di tabel users dan nilainya adalah 'admin'
            return auth()->check() && auth()->user()->role === 'admin';
        });

        // 🛑 PENTING: Fix untuk Pagination (Bootstrap 5) 🛑
        // Jika tampilan pagination Anda (seperti di daftar produk/order) terlihat aneh
        // Anda mungkin perlu mengaktifkan ini jika belum
        // \Illuminate\Pagination\Paginator::useBootstrapFive(); 
        
        // Atau jika Anda menggunakan Tailwind (Default Breeze):
        // \Illuminate\Pagination\Paginator::useTailwind(); // Sudah default
    }
}