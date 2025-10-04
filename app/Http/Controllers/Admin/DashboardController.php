<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

// Import model yang dibutuhkan
use App\Models\Order;
use App\Models\RedeemCode;

class DashboardController extends Controller
{
    /**
     * Tampilkan Admin Dashboard dengan data statistik.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ==========================================
        // 1. PENGAMBILAN DATA STATISTIK REAL-TIME
        // ==========================================

        // Total Orders (Semua waktu)
        $totalOrders = Order::count();

        // Total Revenue (Asumsi: dari order yang LUNAS/COMPLETED, bulan ini)
        $revenue = Order::where('status', 'completed')
                        ->whereMonth('created_at', now()->month)
                        ->sum('total_price'); 

        // 🛑 PERBAIKAN: Stok Kode Tersedia 
        // Menggunakan kolom 'used_at' yang bernilai NULL (belum digunakan)
        $stockAvailable = RedeemCode::whereNull('used_at')->count();
        
        // Pesanan Tertunda 
        $pendingOrders = Order::whereIn('status', ['pending', 'waiting_payment'])->count();


        // ==========================================
        // 2. FORMATTING DAN PENGIRIMAN DATA KE VIEW
        // ==========================================

        // Formatting angka untuk tampilan
        // Asumsi: total_price adalah integer/float
        $formattedRevenue = 'Rp ' . number_format($revenue, 0, ',', '.');
        
        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'revenue' => $formattedRevenue,
            'stockAvailable' => $stockAvailable,
            'pendingOrders' => $pendingOrders,
        ]);
    }
}