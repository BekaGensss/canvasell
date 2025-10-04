<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-slate-800 leading-tight flex items-center">
            <i class="fas fa-boxes-stacked text-emerald-600 me-3"></i>
            {{ __('Kelola Produk Canva') }}
        </h2>
    </x-slot>

    <div class="py-8 lg:py-10 bg-gray-50"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pesan Notifikasi (Lebih Menonjol) --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-md flex items-center" role="alert">
                    <i class="fas fa-check-circle me-3 text-lg"></i>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-2xl rounded-xl">
                
                <div class="p-6 sm:p-8">
                    
                    {{-- Judul & Tombol Aksi --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-slate-800">Daftar Produk</h3>
                        <a href="{{ route('admin.products.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition duration-150 shadow-lg shadow-emerald-400/50">
                            <i class="fas fa-plus-circle me-2"></i>
                            Tambah Produk Baru
                        </a>
                    </div>

                    {{-- 🛑 TABEL PRODUK (Clean, Striped, Modern) 🛑 --}}
                    <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Gambar</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50 transition duration-100">
                                        {{-- Gambar --}}
                                        <td class="px-6 py-3 whitespace-nowrap">
                                            @if ($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded-md shadow-sm border border-gray-100">
                                            @else
                                                <div class="h-10 w-10 bg-gray-200 rounded-md flex items-center justify-center text-gray-500 text-xs">IMG</div>
                                            @endif
                                        </td>
                                        {{-- Nama Produk --}}
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-slate-800">{{ $product->name }}</td>
                                        {{-- Harga --}}
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                        {{-- Status --}}
                                        <td class="px-6 py-3 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                                {{ $product->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        {{-- Aksi --}}
                                        <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-medium space-x-3">
                                            
                                            {{-- 🛑 TOMBOL EDIT: Ditingkatkan secara Visual 🛑 --}}
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="text-blue-600 hover:text-blue-800 transition duration-150 p-2 rounded-lg bg-blue-50 hover:bg-blue-100 font-semibold text-xs inline-flex items-center shadow-sm">
                                                <i class="fas fa-edit me-1 text-sm"></i> Edit
                                            </a>
                                            
                                            {{-- 🛑 TOMBOL HAPUS: Ditingkatkan secara Visual 🛑 --}}
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus produk {{ $product->name }}? Semua kode redeem terkait akan terhapus!');">
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
                                            <i class="fas fa-circle-exclamation me-2"></i> Belum ada produk yang ditambahkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>