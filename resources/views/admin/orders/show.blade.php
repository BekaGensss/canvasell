<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-slate-800 leading-tight flex items-center">
            <i class="fas fa-file-invoice text-emerald-600 me-3"></i>
            {{ __('Detail Pemesanan') }}: <span class="text-blue-600 ml-2 font-mono">{{ $order->order_code }}</span>
        </h2>
    </x-slot>

    <div class="py-8 lg:py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.orders.index') }}" 
               class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-slate-800 transition duration-150 p-2 rounded-lg bg-gray-50 hover:bg-gray-100 border border-gray-200 mb-6">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Daftar Order
            </a>

            <div class="bg-white shadow-2xl rounded-xl p-6 sm:p-8">
                
                <h3 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-3">Status Transaksi & Detail</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- 🛑 KOLOM KIRI: RINGKASAN & STATUS ORDER (Lebih Menonjol) 🛑 --}}
                    <div class="lg:col-span-1 border-r border-gray-100 pr-8">
                        <h4 class="text-lg font-extrabold text-slate-700 mb-4 flex items-center">
                            <i class="fas fa-check-circle me-2 text-emerald-500"></i> Status Order
                        </h4>
                        
                        <div class="space-y-4">
                            <p class="text-sm font-medium text-gray-500">Kode Order:</p>
                            <h5 class="text-2xl font-extrabold text-blue-600 font-mono">{{ $order->order_code }}</h5>
                            
                            <p class="text-sm font-medium text-gray-500 pt-3">Total Bayar:</p>
                            <h5 class="text-2xl font-extrabold text-red-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</h5>
                            
                            <p class="text-sm font-medium text-gray-500 pt-3">Status Saat Ini:</p>
                            @php
                                $statusClass = [
                                    'completed' => 'bg-green-600',
                                    'paid' => 'bg-green-600',
                                    'pending' => 'bg-yellow-600',
                                    'waiting_payment' => 'bg-yellow-600',
                                    'failed' => 'bg-red-600',
                                ][$order->status] ?? 'bg-gray-600';
                            @endphp
                            <span class="px-3 py-1.5 inline-flex text-md leading-5 font-bold rounded-lg text-white {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                            
                            <p class="text-xs text-gray-500 mt-4">Order dibuat pada: {{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    {{-- 🛑 KOLOM TENGAH: DATA PELANGGAN & PRODUK 🛑 --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        {{-- BLOK PELANGGAN --}}
                        <div class="p-5 border border-gray-200 rounded-lg bg-gray-50">
                            <h4 class="text-lg font-semibold text-slate-700 mb-3 flex items-center border-b pb-2">
                                <i class="fas fa-user-circle me-2 text-blue-500"></i> Data Pelanggan
                            </h4>
                            <div class="space-y-2 text-sm text-slate-700">
                                <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                                <p><strong>Email:</strong> <a href="mailto:{{ $order->customer_email }}" class="text-blue-500 hover:underline">{{ $order->customer_email }}</a></p>
                                <p><strong>WhatsApp:</strong> {{ $order->customer_phone }}</p>
                            </div>
                        </div>

                        {{-- BLOK PRODUK --}}
                        <div class="p-5 border border-gray-200 rounded-lg bg-gray-50">
                            <h4 class="text-lg font-semibold text-slate-700 mb-3 flex items-center border-b pb-2">
                                <i class="fas fa-box-open me-2 text-emerald-500"></i> Detail Produk
                            </h4>
                            <p class="text-sm text-slate-700"><strong>Nama Produk:</strong> {{ $order->product->name ?? 'Produk Dihapus' }}</p>
                        </div>
                        
                        {{-- BLOK KODE REDEEM --}}
                        <div class="p-5 border border-2 rounded-lg {{ $redeemCode ? 'border-emerald-300' : 'border-gray-300' }} bg-white shadow-sm">
                            <h4 class="text-lg font-semibold text-slate-700 mb-3 flex items-center border-b pb-2">
                                <i class="fas fa-key me-2 {{ $redeemCode ? 'text-emerald-500' : 'text-yellow-500' }}"></i> Kode Redeem Dialokasikan
                            </h4>
                            @if ($redeemCode)
                                <p class="mb-2"><strong>Kode:</strong> <span class="font-mono text-xl text-emerald-600 font-extrabold">{{ $redeemCode->code }}</span></p>
                                <p class="text-sm text-slate-600"><strong>Waktu Kirim:</strong> {{ $redeemCode->used_at?->format('d M Y H:i:s') ?? 'N/A' }}</p>
                                <p class="text-sm text-slate-600 mt-2"><strong>Status Kode:</strong> 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                        {{ ucfirst($redeemCode->status) }}
                                    </span>
                                </p>
                            @else
                                <p class="text-orange-500 font-medium">Kode Redeem belum dialokasikan untuk order ini.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 🛑 BLOK AKSI MANUAL ADMIN 🛑 --}}
                <div class="mt-10 pt-6 border-t border-gray-200">
                    <h4 class="text-xl font-bold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-tools me-2 text-red-500"></i> Aksi Manual Admin
                    </h4>
                    
                    <div class="flex items-center space-x-4">
                        @if ($order->status == 'pending' || $order->status == 'waiting_payment')
                            <button class="px-4 py-2 bg-yellow-500 text-white rounded-lg opacity-50 cursor-not-allowed font-medium shadow-md">
                                <i class="fas fa-hourglass-half me-2"></i> Bayar Manual (Disabled)
                            </button>
                            <p class="text-sm text-gray-600">Order masih Pending. Harap tunggu konfirmasi Webhook.</p>
                            
                        @elseif ($order->status == 'paid' && !$redeemCode)
                            {{-- Aksi URGENT: Jika sudah bayar tapi kode belum terkirim --}}
                            <a href="#" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium shadow-md">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Kode Redeem Manual (URGENT!)
                            </a>
                            <p class="text-sm text-red-500 font-semibold">Status Paid, tapi Kode belum terikat. Harus dialokasikan secara manual!</p>
                            
                        @else
                            <button class="px-4 py-2 bg-gray-500 text-white rounded-lg opacity-50 cursor-not-allowed font-medium">
                                Tidak Ada Aksi Tersedia
                            </button>
                            <p class="text-sm text-gray-500">Order sudah Selesai (Completed) atau masih Pending.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>