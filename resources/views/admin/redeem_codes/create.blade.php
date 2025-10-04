{{-- resources/views/admin/redeem_codes/create.blade.php (Rombak Total) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-slate-800 leading-tight flex items-center">
            <i class="fas fa-square-plus text-emerald-600 me-3"></i>
            {{ __('Tambah Satu Kode Redeem Baru') }}
        </h2>
    </x-slot>

    <div class="py-8 lg:py-10 bg-gray-50">
        {{-- Menggunakan lebar max-w-3xl agar form terlihat ringkas --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Card Formulir Utama: Mewah dan Terstruktur --}}
            <div class="bg-white shadow-2xl rounded-xl p-6 sm:p-8 border-t-4 border-emerald-600">
                
                {{-- Tombol Kembali (Navigasi) --}}
                <div class="mb-6 flex justify-start">
                    <a href="{{ route('admin.redeem-codes.index') }}" 
                       class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-slate-800 transition duration-150 p-2 rounded-lg bg-gray-50 hover:bg-gray-100 border border-gray-200">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Daftar Kode
                    </a>
                </div>
                
                {{-- Judul Card --}}
                <h3 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-3">
                    Input Kode Manual
                </h3>
                
                {{-- Error Validation (Gaya Baru, Lebih Menonjol) --}}
                @if ($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg shadow-sm mb-6" role="alert">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-lg me-3 mt-1"></i>
                            <div>
                                <strong class="font-bold block mb-1">Ada beberapa masalah dengan input Anda:</strong>
                                <ul class="mt-2 list-disc list-inside space-y-1 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.redeem-codes.store') }}" class="space-y-6">
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

                    {{-- 2. Input Kode Redeem --}}
                    <div>
                        <x-input-label for="code" :value="__('Kode Redeem')" class="font-semibold text-slate-700"/>
                        <x-text-input 
                            id="code" 
                            name="code" 
                            type="text" 
                            class="mt-1 block w-full uppercase border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500/50 transition duration-150" 
                            :value="old('code')" 
                            required 
                            placeholder="Misal: CANVA-PRO-ABCDE" 
                        />
                        <p class="mt-2 text-xs text-slate-500">Kode akan disimpan dalam format huruf besar (uppercase).</p>
                        <x-input-error class="mt-2" :messages="$errors->get('code')" />
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                        {{-- Tombol Submit (Aksen Emerald) --}}
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <i class="fas fa-save me-2"></i>
                            {{ __('Simpan Kode') }}
                        </button>
                        
                        {{-- Tombol Batal --}}
                        <a href="{{ route('admin.redeem-codes.index') }}" class="text-slate-600 hover:text-slate-800 transition duration-150 font-medium">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
            
            {{-- 🛑 Link ke Import Massal (Menonjol) 🛑 --}}
            <div class="mt-6 text-center p-4 bg-white rounded-lg shadow-md border-t-4 border-gray-100">
                <p class="text-sm text-slate-600 mb-2 font-medium">Atau, ingin memasukkan banyak kode sekaligus?</p>
                <a href="{{ route('admin.redeem-codes.import.form') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-bold transition duration-150">
                    <i class="fas fa-file-csv me-2"></i> Lanjut ke Form Import Massal (CSV)
                </a>
            </div>
        </div>
    </div>
</x-app-layout>