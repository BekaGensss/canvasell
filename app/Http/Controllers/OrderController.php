<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\RedeemCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Untuk logging error jika diperlukan

class OrderController extends Controller
{
    // 1. Membuat Order Baru (dari form checkout)
    public function store(Request $request)
    {
        // === KEAMANAN: VALIDASI DATA CUSTOMER ===
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:255', 
            'customer_phone' => 'required|string|max:20',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // === Cek Ketersediaan Kode Redeem ===
        $availableCodes = RedeemCode::where('product_id', $product->id)
                                    ->where('status', 'available')
                                    ->count();
        if ($availableCodes === 0) {
            return redirect()->back()->withErrors(['stok' => 'Maaf, stok Kode Redeem untuk produk ini sedang habis.'])->withInput();
        }

        try {
            DB::beginTransaction();

            // 1. Buat Order Code Unik
            $orderCode = 'INV-' . strtoupper(Str::random(5) . now()->format('YmdHis'));

            // 2. Buat Entri Order
            $order = Order::create([
                'order_code' => $orderCode,
                'product_id' => $product->id,
                'total_price' => $product->price, 
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'status' => 'pending',
                'payment_method' => 'VA/QRIS', 
            ]);

            DB::commit();

            // 3. Arahkan ke halaman konfirmasi/pembayaran
            return redirect()->route('order.show', $order->order_code);

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Failed to store order: " . $e->getMessage()); // Logging di production
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat memproses order. Coba lagi.')->withInput();
        }
    }

    // 2. Tampilkan Halaman Konfirmasi/Pembayaran
    public function show(string $order_code)
    {
        $order = Order::where('order_code', $order_code)->with('product')->firstOrFail();
        $paymentLink = route('order.show', $order_code) . '?action=pay_now'; 
        
        return view('frontend.order_confirmation', compact('order', 'paymentLink'));
    }

    // 3. Webhook Pembayaran (Simulasi Sederhana untuk Proses Bisnis)
    public function webhook(Request $request)
    {
        // Mendapatkan data simulasi
        $orderCode = $request->order_code;
        $paymentStatus = $request->status; 
        
        $order = Order::where('order_code', $orderCode)
                      ->where('status', 'pending')
                      ->first();

        if (!$order) {
            return response()->json(['message' => 'Order already processed or not found'], 200);
        }
        
        if ($paymentStatus === 'success') {
            try {
                DB::beginTransaction();

                // 1. Ambil SATU Kode Redeem yang available
                $redeemCode = RedeemCode::where('product_id', $order->product_id)
                                        ->where('status', 'available')
                                        ->lockForUpdate() 
                                        ->first();

                if (!$redeemCode) {
                    DB::rollBack();
                    // Jika stok habis setelah order dibuat
                    return response()->json(['message' => 'Critical: No available redeem code found.'], 500); 
                }

                // 2. Update status Redeem Code
                $redeemCode->update([
                    'status' => 'used',
                    'order_id' => $order->id,
                    'used_at' => now(),
                ]);

                // 3. Update status Order
                $order->update(['status' => 'completed']);
                
                DB::commit();
                
                // 4. Kirim Email ke pelanggan (Kode Redeem)
                $this->sendRedeemCodeEmail($order, $redeemCode);

                // 5. Kirim Notifikasi ke Admin (PENAMBAHAN BARU)
                $this->notifyAdminPaymentSuccess($order);

                // Redirect kembali ke halaman konfirmasi order untuk menampilkan status 'completed'
                return redirect()->route('order.show', $order->order_code)->with('success', 'Pembayaran berhasil dikonfirmasi!');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Webhook failed for order {$order->id}: " . $e->getMessage());
                return response()->json(['message' => 'Transaction failed due to internal error: ' . $e->getMessage()], 500);
            }
        } else if ($paymentStatus === 'failure') {
            $order->update(['status' => 'failed']);
            return response()->json(['message' => 'Payment failed, order status updated'], 200);
        }

        return response()->json(['message' => 'Status not handled'], 200);
    }
    
    // Fungsi Pembantu: Mengirim Email Kode Redeem ke Pelanggan
    private function sendRedeemCodeEmail(Order $order, RedeemCode $code)
    {
        Mail::raw("Selamat, pembayaran Anda untuk Order #$order->order_code berhasil. 
                    
Kode Redeem Canva Pro Anda adalah:
{$code->code}
                    
Terima kasih telah berbelanja di CanvaSell!", 
        function ($message) use ($order) {
            $message->to($order->customer_email)
                    ->subject('Kode Redeem Canva Pro Anda (Order ' . $order->order_code . ')');
        });
    }

    // Fungsi Pembantu: Mengirim Notifikasi Pembayaran ke Admin
    private function notifyAdminPaymentSuccess(Order $order)
    {
        // Ambil email admin dari konfigurasi .env
        $adminEmail = env('MAIL_ADMIN_NOTIFY', env('MAIL_FROM_ADDRESS', 'admin@canvasell.com')); 

        Mail::raw("NOTIFIKASI PEMBAYARAN SUKSES!
                    
Order #{$order->order_code} telah dikonfirmasi (Status: Completed).
Produk: {$order->product->name}
Total: Rp" . number_format($order->total_price, 0, ',', '.') . "
Pelanggan: {$order->customer_email}
                    
Sistem telah mengirim Kode Redeem secara otomatis.
Periksa di Panel Admin jika ada masalah.", 
        function ($message) use ($order, $adminEmail) {
            $message->to($adminEmail)
                    ->subject('[SUCCESS] Pembayaran Masuk: Order ' . $order->order_code);
        });
    }
}