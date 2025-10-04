<?php
// app/Http/Controllers/Admin/OrderManagementController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; 
use App\Models\RedeemCode; 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB; // Diperlukan untuk transaksi

class OrderManagementController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan (index view).
     */
    public function index(): View
    {
        // Mengambil semua order dengan relasi 'product', diurutkan berdasarkan yang terbaru
        $orders = Order::with('product')->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.orders.index', compact('orders')); 
    }

    /**
     * Menampilkan detail satu pesanan tertentu (show view).
     */
    public function show(Order $order): View
    {
        $order->load(['product']);
        $redeemCode = RedeemCode::where('order_id', $order->id)->first();
        
        return view('admin.orders.show', compact('order', 'redeemCode'));
    }

    /**
     * Hapus order spesifik (single delete).
     */
    public function destroy(Order $order): RedirectResponse
    {
        $allowedStatuses = ['failed', 'pending', 'waiting_payment'];

        if (!in_array($order->status, $allowedStatuses)) {
            return redirect()->route('admin.orders.index')->with('error', 'Gagal: Order yang sudah lunas tidak dapat dihapus.');
        }

        try {
            $orderCode = $order->order_code;
            
            DB::transaction(function () use ($order) {
                // Putuskan ikatan kode redeem
                RedeemCode::where('order_id', $order->id)->update(['order_id' => null]); 
                // Hapus order
                $order->delete();
            });

            return redirect()->route('admin.orders.index')->with('success', 'Order #' . $orderCode . ' telah berhasil dihapus.');
            
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Gagal menghapus order: Terjadi kesalahan sistem.');
        }
    }

    /**
     * 🛑 BARU: Hapus semua pesanan yang merupakan riwayat lama (mass delete).
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearHistory(): RedirectResponse
    {
        // Tentukan status yang termasuk riwayat lama dan aman untuk dibersihkan
        $statusesToClear = ['completed', 'failed', 'paid'];
        
        try {
            $deletedCount = 0;
            
            DB::transaction(function () use ($statusesToClear, &$deletedCount) {
                
                // 1. Ambil ID order yang akan dihapus
                $ordersToClear = Order::whereIn('status', $statusesToClear);
                $orderIds = $ordersToClear->pluck('id');

                // 2. Putuskan ikatan kode redeem (Set order_id = NULL)
                RedeemCode::whereIn('order_id', $orderIds)->update(['order_id' => null, 'status' => 'available']);
                
                // 3. Hapus order yang bersangkutan dan hitung jumlah yang dihapus
                $deletedCount = $ordersToClear->delete();
            });
            
            return redirect()->route('admin.orders.index')->with('success', 'Riwayat ' . $deletedCount . ' pesanan telah berhasil dibersihkan.');
            
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Gagal membersihkan riwayat pesanan: Terjadi kesalahan database. Cek Log: ' . $e->getMessage());
        }
    }
}