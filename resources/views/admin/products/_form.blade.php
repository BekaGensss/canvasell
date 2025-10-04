@props(['product' => new \App\Models\Product()])

<div class="space-y-6">
    
    {{-- 🛑 Error Validation (Gaya Baru, Lebih Menonjol) 🛑 --}}
    @if ($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-lg me-3 mt-1"></i>
                <div>
                    <strong class="font-bold block mb-1">Ada beberapa masalah dengan input Anda:</strong>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    
    {{-- 1. Input Nama Produk --}}
    <div>
        <x-input-label for="name" :value="__('Nama Produk')" class="font-semibold text-slate-700" />
        <x-text-input 
            id="name" 
            name="name" 
            type="text" 
            class="mt-1 block w-full border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500/50 transition duration-150" 
            :value="old('name', $product->name)" 
            required 
            autofocus 
        />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    {{-- 2. Input Deskripsi --}}
    <div>
        <x-input-label for="description" :value="__('Deskripsi')" class="font-semibold text-slate-700" />
        <textarea 
            id="description" 
            name="description" 
            rows="5" 
            class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500/50 rounded-lg shadow-sm mt-1 block w-full text-sm transition duration-150"
        >{{ old('description', $product->description) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>

    {{-- 3. Input Harga --}}
    <div>
        <x-input-label for="price" :value="__('Harga (Rp)')" class="font-semibold text-slate-700" />
        <x-text-input 
            id="price" 
            name="price" 
            type="number" 
            class="mt-1 block w-full border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500/50 transition duration-150" 
            :value="old('price', $product->price)" 
            required 
            min="1000" 
        />
        <x-input-error class="mt-2" :messages="$errors->get('price')" />
    </div>

    {{-- 4. Input Gambar --}}
    <div>
        <x-input-label for="image" :value="__('Gambar Produk')" class="font-semibold text-slate-700" />
        <input 
            id="image" 
            name="image" 
            type="file" 
            class="mt-1 block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-1.5 
                   file:mr-4 file:py-2 file:px-4
                   file:rounded-md file:border-0
                   file:text-sm file:font-semibold
                   file:bg-emerald-50 file:text-emerald-700
                   hover:file:bg-emerald-100 transition duration-150 cursor-pointer" 
        />
        <x-input-error class="mt-2" :messages="$errors->get('image')" />

        @if ($product->image)
            <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200 inline-block">
                <p class="text-xs font-medium text-slate-500 mb-1">Gambar saat ini:</p>
                <img src="{{ Storage::url($product->image) }}" alt="Current Image" class="h-16 w-16 object-cover rounded-md shadow-md">
            </div>
        @endif
    </div>
    
    {{-- 5. Checkbox Status Aktif --}}
    <div class="flex items-center pt-2">
        <input 
            id="is_active" 
            name="is_active" 
            type="checkbox" 
            value="1" 
            {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} 
            class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 w-5 h-5 cursor-pointer"
        >
        <label for="is_active" class="ml-3 text-sm text-slate-700 font-medium cursor-pointer">
            Aktifkan Produk (Tampilkan di Halaman Pembelian)
        </label>
    </div>

    {{-- 6. Tombol Aksi (Submit & Batal) --}}
    <div class="flex items-center gap-4 pt-6 border-t mt-6 border-gray-100">
        
        {{-- Tombol Submit (Aksen Emerald) --}}
        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
            <i class="fas fa-save me-2"></i>
            {{ isset($product->id) ? 'Perbarui Produk' : 'Simpan Produk' }}
        </button>
        
        {{-- Tombol Batal (Aksen Simpel) --}}
        <a href="{{ route('admin.products.index') }}" class="text-slate-600 hover:text-slate-800 transition duration-150 font-medium">
            Batal
        </a>
    </div>
</div>