{{-- resources/views/admin/orders/index.blade.php (Rombak Total) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-slate-800 leading-tight flex items-center">
            <i class="fas fa-receipt text-emerald-600 me-3"></i>
            {{ __('Daftar Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-8 lg:py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-2xl rounded-xl">
                
                <div class="p-6 sm:p-8">
                    
                    <h3 class="text-2xl font-bold text-slate-800 mb-6">Semua Transaksi Pelanggan</h3>

                    {{-- Notifikasi (Lebih Menonjol) --}}
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-md flex items-center" role="alert">
                            <i class="fas fa-check-circle me-3 text-lg"></i>
                            <span class="block sm:inline font-medium">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-md flex items-center" role="alert">
                            <i class="fas fa-times-circle me-3 text-lg"></i>
                            <span class="block sm:inline font-medium">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    {{-- 🛑 FORM FILTER STATUS & HAPUS MASSAL 🛑 --}}
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-8 p-4 border border-gray-200 rounded-lg bg-gray-50 shadow-sm flex space-x-4 items-end">
                        
                        <div class="flex-1 max-w-sm">
                            <label for="status" class="block text-sm font-semibold text-slate-700 mb-1">Filter Status</label>
                            <select id="status" name="status" class="block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500/50 text-sm shadow-sm">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending/Menunggu Pembayaran</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid/Menunggu Alokasi Kode</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed/Selesai</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed/Gagal</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition h-10 font-medium text-sm inline-flex items-center">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        
                        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition h-10 font-medium text-sm inline-flex items-center">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>

                    </form>
                    
                    {{-- 🛑 TOMBOL HAPUS RIWAYAT (Di luar form filter GET) 🛑 --}}
                    <div class="flex justify-end mb-6">
                        <form method="POST" action="{{ route('admin.orders.clear-history') }}" 
                            onsubmit="return confirm('⚠️ PERINGATAN! Anda yakin ingin MENGHAPUS SEMUA RIWAYAT (Completed/Paid/Failed) secara permanen? Aksi ini tidak dapat dibatalkan.');" 
                            class="inline-flex">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 transition h-10 font-medium text-sm inline-flex items-center shadow-md">
                                <i class="fas fa-eraser me-1"></i> HAPUS RIWAYAT LAMA
                            </button>
                        </form>
                    </div>


                    {{-- 🛑 TABEL ORDER (Clean, Striped, Modern) 🛑 --}}
                    <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Order ID & Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition duration-100">
                                        {{-- Order ID & Waktu --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
                                            #{{ $order->order_code }}
                                            <br>
                                            <span class="text-xs font-normal text-gray-500">{{ $order->created_at->format('d M H:i') }}</span>
                                        </td>
                                        {{-- Pelanggan --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800">
                                            {{ $order->customer_name }}
                                            <br>
                                            <span class="text-xs text-gray-500 font-mono">{{ $order->customer_email }}</span>
                                        </td>
                                        {{-- Produk --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $order->product->name ?? 'Dihapus' }}</td>
                                        {{-- Total --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        {{-- Status --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClass = [
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'paid' => 'bg-green-100 text-green-800',
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'waiting_payment' => 'bg-yellow-100 text-yellow-800',
                                                    'failed' => 'bg-red-100 text-red-800',
                                                ][$order->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>
                                        {{-- Aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-3">
                                            
                                            {{-- TOMBOL DETAIL --}}
                                            <a href="{{ route('admin.orders.show', $order) }}" 
                                               class="text-blue-600 hover:text-blue-800 transition duration-150 p-2 rounded-lg bg-blue-50 hover:bg-blue-100 font-semibold text-xs inline-flex items-center shadow-sm">
                                                <i class="fas fa-eye me-1 text-sm"></i> Detail
                                            </a>
                                            
                                            {{-- TOMBOL HAPUS --}}
                                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" 
                                                  onsubmit="return confirm('PERINGATAN: Menghapus order ini bersifat permanen dan tidak disarankan kecuali ini adalah transaksi uji coba atau gagal. Lanjutkan?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition duration-150 p-2 rounded-lg bg-red-50 hover:bg-red-100 font-semibold text-xs inline-flex items-center shadow-sm">
                                                    <i class="fas fa-trash-alt me-1 text-sm"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-slate-500 font-medium text-lg bg-gray-50">
                                            <i class="fas fa-circle-exclamation me-2"></i> Belum ada pemesanan yang masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>