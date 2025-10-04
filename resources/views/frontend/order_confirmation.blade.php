{{-- resources/views/frontend/order_confirmation.blade.php --}}
<x-guest-layout>
    <x-slot name="slot">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-12">
            
            @if ($order->status == 'completed')
                {{-- Status Completed --}}
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-6 rounded-lg mb-8 shadow-md text-center">
                    <h4 class="text-3xl font-bold mb-3">Pembayaran Berhasil Dikonfirmasi! 🎉</h4>
                    <p class="text-lg">Kode Redeem telah dikirimkan ke email Anda: **{{ $order->customer_email }}**.</p>
                    <p class="text-sm mt-2 text-green-600">Mohon cek folder Spam/Promosi jika tidak ada di Inbox Anda.</p>
                </div>
            @elseif ($order->status == 'failed')
                 {{-- Status Gagal --}}
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-6 rounded-lg mb-8 shadow-md text-center">
                    <h4 class="text-3xl font-bold mb-3">Pembayaran Gagal/Kadaluarsa</h4>
                    <p class="text-lg">Order #{{ $order->order_code }} gagal diproses. Silakan buat pesanan baru.</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-8">
                
                <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-6 border-b pb-3">
                    Detail Pesanan #{{ $order->order_code }}
                </h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Produk:</p>
                        <p class="text-xl font-semibold mb-2">{{ $order->product->name }}</p>
                        <p class="text-gray-600 dark:text-gray-400">Total Pembayaran:</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Status Saat Ini:</p>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full 
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800 
                            @elseif($order->status == 'completed') bg-green-100 text-green-800 
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Penerima Kode:</p>
                        <p class="font-semibold">{{ $order->customer_email }}</p>
                    </div>
                </div>

                @if ($order->status == 'pending')
                    
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-t pt-4">Pilih Metode Pembayaran</h2>
                    
                    {{-- ACCORDION PEMBAYARAN --}}
                    <div class="space-y-3">
                        
                        @php
                            $payments = [
                                ['name' => 'DANA', 'number' => '0812-3456-7890', 'icon_class' => 'bg-blue-600 text-white', 'acc' => 'a.n. CanvaSell', 'fee' => 0],
                                ['name' => 'GOPAY', 'number' => '0812-3456-7890', 'icon_class' => 'bg-green-500 text-white', 'acc' => 'a.n. CanvaSell', 'fee' => 0],
                                ['name' => 'BCA (Virtual Account)', 'number' => '1234 5678 9000 0001', 'icon_class' => 'bg-blue-900 text-white', 'acc' => 'a.n. PT CanvaSell', 'fee' => 2500],
                                ['name' => 'BRI (Transfer Manual)', 'number' => '5432-1098-7654-3210', 'icon_class' => 'bg-blue-700 text-white', 'acc' => 'a.n. PT CanvaSell', 'fee' => 0],
                            ];
                        @endphp

                        @foreach ($payments as $payment)
                            <div x-data="{ open: false }" class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-md">
                                {{-- Tombol Buka/Tutup --}}
                                <button @click="open = ! open" class="w-full flex justify-between items-center p-4 text-left font-semibold hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    <div class="flex items-center space-x-3">
                                        <span class="w-8 h-5 flex items-center justify-center rounded text-xs {{ $payment['icon_class'] }}">{{ $payment['name'][0] }}</span>
                                        <span class="text-gray-900 dark:text-gray-100">{{ $payment['name'] }}</span>
                                    </div>
                                    <span class="text-sm text-gray-500">
                                        Total: Rp{{ number_format($order->total_price + $payment['fee'], 0, ',', '.') }}
                                    </span>
                                </button>

                                {{-- Isi Accordion --}}
                                <div x-show="open" x-collapse>
                                    <div class="p-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200 mb-2">Nomor Tujuan:</p>
                                        <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-3 rounded-md border dark:border-gray-600">
                                            <span class="text-lg font-mono text-indigo-600 dark:text-indigo-400">{{ $payment['number'] }}</span>
                                            {{-- Tambahkan tombol copy jika mau --}}
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Atas Nama: {{ $payment['acc'] }}</p>

                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200 mt-4 mb-2">Jumlah Transfer Tepat:</p>
                                        <span class="text-2xl font-extrabold text-red-600 dark:text-red-400">
                                            Rp{{ number_format($order->total_price + $payment['fee'], 0, ',', '.') }}
                                        </span>
                                        <p class="text-xs text-red-500">(Termasuk biaya admin Rp{{ number_format($payment['fee'], 0, ',', '.') }})</p>
                                        
                                        {{-- TOMBOL KONFIRMASI PEMBAYARAN (SIMULASI WEBHOOK) --}}
                                        <div class="mt-6">
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Setelah transfer, klik tombol di bawah ini (simulasi konfirmasi):</p>
                                            
                                            <form method="POST" action="{{ route('payment.webhook') }}" onsubmit="this.querySelector('button').disabled = true; this.querySelector('button').innerText = 'Memproses...';">
                                                @csrf
                                                <input type="hidden" name="order_code" value="{{ $order->order_code }}">
                                                <input type="hidden" name="status" value="success">
                                                <button type="submit" class="w-full py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition duration-150 shadow-lg disabled:opacity-50 disabled:cursor-wait">
                                                    Saya Sudah Bayar, Konfirmasi Sekarang
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <a href="{{ route('homepage') }}" class="mt-8 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-600 inline-block font-medium">Lanjutkan Belanja &rarr;</a>
            </div>
        </div>
    </x-slot>
</x-guest-layout>