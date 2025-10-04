{{-- resources/views/admin/redeem_codes/import.blade.php (Rombak Total) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-slate-800 leading-tight flex items-center">
            <i class="fas fa-file-import text-emerald-600 me-3"></i>
            {{ __('Import Massal Kode Redeem') }}
        </h2>
    </x-slot>

    <div class="py-8 lg:py-10 bg-gray-50">
        {{-- Menggunakan lebar max-w-3xl agar form terlihat ringkas --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Card Formulir Utama: Mewah dan Terstruktur --}}
            <div class="bg-white shadow-2xl rounded-xl p-6 sm:p-8 border-t-4 border-emerald-500">
                
                {{-- Tombol Kembali (Navigasi) --}}
                <div class="mb-6 flex justify-start">
                    <a href="{{ route('admin.redeem-codes.index') }}" 
                       class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-slate-800 transition duration-150 p-2 rounded-lg bg-gray-50 hover:bg-gray-100 border border-gray-200">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Daftar Kode
                    </a>
                </div>
                
                <h3 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-3">
                    Unggah File CSV
                </h3>
                
                {{-- 🛑 Panduan Format (Estetik dan Menonjol) 🛑 --}}
                <div class="mb-8 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 rounded-lg shadow-sm">
                    <p class="font-bold flex items-center mb-1">
                        <i class="fas fa-lightbulb me-2 text-xl"></i> Panduan Format CSV:
                    </p>
                    <p class="text-sm text-yellow-700">Pastikan file CSV Anda hanya memiliki **SATU KOLOM** yang berisi **KODE REDEEM** (tanpa *header* atau kolom lain).</p>
                    <pre class="bg-yellow-100 text-yellow-900 p-2 mt-2 rounded-md border border-yellow-200 text-sm overflow-x-auto">
KODE-12345
KODE-ABCDE
KODE-7890</pre>
                </div>

                {{-- Notifikasi Error (Gaya baru) --}}
                @if ($errors->any() || session('error'))
                    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg shadow-sm mb-6" role="alert">
                        <div class="flex items-start">
                            <i class="fas fa-times-circle text-lg me-3 mt-1"></i>
                            <div>
                                <strong class="font-bold block mb-1">Gagal Import!</strong>
                                <ul class="mt-2 list-disc list-inside space-y-1 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    @if (session('error'))
                                        <li>{{ session('error') }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('admin.redeem-codes.import.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    {{-- 1. Pilih Produk --}}
                    <div>
                        <x-input-label for="product_id" :value="__('Pilih Produk Tujuan')" class="font-semibold text-slate-700"/>
                        <select id="product_id" name="product_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/50 transition duration-150" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('product_id')" />
                    </div>

                    {{-- 2. Upload File (Style Emerald) --}}
                    <div>
                        <x-input-label for="csv_file" :value="__('File CSV Kode Redeem')" class="font-semibold text-slate-700"/>
                        <input id="csv_file" name="csv_file" type="file" 
                            class="mt-1 block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-1.5 
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-md file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-emerald-50 file:text-emerald-700
                                   hover:file:bg-emerald-100 transition duration-150 cursor-pointer" 
                            accept=".csv,.txt" 
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('csv_file')" />
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                        {{-- Tombol Submit (Aksen Emerald) --}}
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <i class="fas fa-upload me-2"></i>
                            Proses Import Kode
                        </button>
                        
                        {{-- Tombol Batal --}}
                        <a href="{{ route('admin.redeem-codes.index') }}" class="text-slate-600 hover:text-slate-800 transition duration-150 font-medium">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>