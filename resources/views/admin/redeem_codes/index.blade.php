{{-- resources/views/admin/redeem_codes/index.blade.php (Rombak Total) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-slate-800 leading-tight flex items-center">
            <i class="fas fa-key text-emerald-600 me-3"></i>
            {{ __('Kelola Kode Redeem') }}
        </h2>
    </x-slot>

    <div class="py-8 lg:py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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

            <div class="bg-white overflow-hidden shadow-2xl rounded-xl">
                
                <div class="p-6 sm:p-8">
                    
                    {{-- 🛑 JUDUL & TOMBOL AKSI 🛑 --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-slate-800">Daftar Stok Kode</h3>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.redeem-codes.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-150 shadow-md shadow-blue-300/50">
                                <i class="fas fa-plus me-2"></i>
                                Tambah 1 Kode
                            </a>
                            <a href="{{ route('admin.redeem-codes.import.form') }}" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition duration-150 shadow-md shadow-emerald-300/50">
                                <i class="fas fa-file-import me-2"></i>
                                Import Massal (CSV)
                            </a>
                        </div>
                    </div>

                    {{-- 🛑 FORM FILTER (Clean Card Look) 🛑 --}}
                    <form method="GET" action="{{ route('admin.redeem-codes.index') }}" class="mb-8 p-4 border border-gray-200 rounded-lg bg-gray-50 shadow-sm flex space-x-4 items-end">
                        
                        <div class="flex-1 min-w-[150px]">
                            <label for="status" class="block text-sm font-semibold text-slate-700 mb-1">Filter Status</label>
                            <select id="status" name="status" class="block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500/50 text-sm shadow-sm">
                                <option value="">Semua Status</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Used</option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>
                        
                        <div class="flex-1 min-w-[150px]">
                            <label for="product_id" class="block text-sm font-semibold text-slate-700 mb-1">Filter Produk</label>
                            <select id="product_id" name="product_id" class="block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500/50 text-sm shadow-sm">
                                <option value="">Semua Produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition h-10 font-medium text-sm inline-flex items-center">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        
                        <a href="{{ route('admin.redeem-codes.index') }}" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition h-10 font-medium text-sm inline-flex items-center">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                    </form>

                    {{-- 🛑 TABEL KODE REDEEM (Clean, Striped, Modern) 🛑 --}}
                    <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Kode Redeem</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Digunakan Oleh Order</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($redeemCodes as $code)
                                    <tr class="hover:bg-gray-50 transition duration-100">
                                        {{-- Kode Redeem --}}
                                        <td class="px-6 py-4 whitespace-nowrap font-mono text-sm font-bold text-emerald-600">
                                            {{ $code->code }}
                                        </td>
                                        {{-- Produk --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
                                            {{ $code->product->name ?? 'Produk Dihapus' }}
                                        </td>
                                        {{-- Status --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClass = [
                                                    'available' => 'bg-green-100 text-green-800',
                                                    'used' => 'bg-red-100 text-red-800',
                                                    'expired' => 'bg-yellow-100 text-yellow-800',
                                                ][$code->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusClass }}">
                                                {{ ucfirst($code->status) }}
                                            </span>
                                        </td>
                                        {{-- Digunakan Oleh Order --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                            @if ($code->order_id)
                                                {{-- Asumsi Anda punya route ke detail order --}}
                                                <a href="{{ route('admin.orders.show', $code->order_id) }}" class="font-bold text-blue-600 hover:text-blue-800 hover:underline">
                                                    <i class="fas fa-file-invoice me-1"></i> #{{ $code->order_id }}
                                                </a>
                                            @else
                                                <span class="text-gray-400">Belum Dialokasikan</span>
                                            @endif
                                        </td>
                                        {{-- Aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-3">
                                            
                                            {{-- Tombol Edit Status (Icon Only) --}}
                                            <a href="{{ route('admin.redeem-codes.edit', $code) }}" 
                                               class="text-blue-600 hover:text-blue-800 transition duration-150 p-2 rounded-lg bg-blue-50 hover:bg-blue-100 font-semibold text-xs inline-flex items-center shadow-sm">
                                                <i class="fas fa-edit me-1 text-sm"></i> Edit
                                            </a>
                                            
                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('admin.redeem-codes.destroy', $code) }}" method="POST" class="inline" onsubmit="return confirm('Hati-hati! Apakah Anda yakin ingin menghapus kode redeem ini secara permanen?');">
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
                                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 font-medium text-lg bg-gray-50">
                                            <i class="fas fa-circle-exclamation me-2"></i> Belum ada kode redeem yang ditambahkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $redeemCodes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>