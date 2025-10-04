<?php
// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Penting: Import Auth
use App\Providers\RouteServiceProvider; // Import untuk tujuan redirect

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Logika Keamanan: Cek apakah pengguna sudah login dan rolenya adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Lanjutkan jika Admin
        }

        // 🛑 PERBAIKAN: Alihkan ke Home Toko (RouteServiceProvider::HOME = '/') 🛑
        // Jika bukan Admin (atau belum login), alihkan ke halaman utama (home)
        return redirect(RouteServiceProvider::HOME)->with('error', 'Akses ditolak. Anda bukan Administrator.');
    }
}