@props(['redeemCode' => new \App\Models\RedeemCode(), 'products'])

<div class="space-y-6">
    
    {{-- 🛑 Error Validation (Gaya Baru, Lebih Menonjol) 🛑 --}}
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
    
    {{-- 1. Pilih Produk --}}
    <div>
        <x-input-label for="product_id" :value="__('Produk Terkait')" class="font-semibold text-slate-700"/>
        
        {{-- Logika untuk menentukan apakah select box harus di-disable --}}
        @php
            $isDisabled = $redeemCode->exists && $redeemCode->status !== 'available';
        @endphp

        <select id="product_id" name="product_id" 
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/50 transition duration-150 text-sm 
                @if($isDisabled) bg-gray-100 cursor-not-allowed @endif" 
                required 
                @if($isDisabled) disabled @endif>
            
            <option value="">-- Pilih Produk --</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" {{ old('product_id', $redeemCode->product_id) == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
        
        <x-input-error class="mt-2" :messages="$errors->get('product_id')" />
        
        {{-- Pesan Pemberitahuan Disable --}}
        @if($isDisabled)
            <p class="mt-2 text-sm text-blue-600 font-medium flex items-center">
                <i class="fas fa-info-circle me-2"></i> Produk dikunci karena kode sudah dialokasikan/digunakan.
            </p>
        @endif
    </div>

    {{-- 2. Input Kode Redeem --}}
    <div>
        <x-input-label for="code" :value="__('Kode Redeem')" class="font-semibold text-slate-700"/>
        <x-text-input 
            id="code" 
            name="code" 
            type="text" 
            class="mt-1 block w-full uppercase border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500/50 transition duration-150 font-mono text-base" 
            :value="old('code', $redeemCode->code)" 
            required 
            placeholder="Misal: CANVA-PRO-ABCDE" 
        />
        <x-input-error class="mt-2" :messages="$errors->get('code')" />
    </div>

    {{-- 3. Status Kode (Hanya Muncul di Halaman Edit) --}}
    @if ($redeemCode->exists)
    <div>
        <x-input-label for="status" :value="__('Status Kode')" class="font-semibold text-slate-700"/>
        <select id="status" name="status" 
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/50 transition duration-150 text-sm" required>
            
            <option value="available" {{ old('status', $redeemCode->status) == 'available' ? 'selected' : '' }}>
                Available (Siap Jual)
            </option>
            <option value="used" {{ old('status', $redeemCode->status) == 'used' ? 'selected' : '' }} @if($redeemCode->status == 'used') disabled @endif>
                Used (Sudah Terjual/Dipakai)
            </option>
            <option value="expired" {{ old('status', $redeemCode->status) == 'expired' ? 'selected' : '' }}>
                Expired (Kadaluarsa)
            </option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('status')" />
    </div>
    @endif

    <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
        {{-- Tombol Submit (Aksen Primary: Biru untuk Edit, Emerald untuk Create) --}}
        <button type="submit" 
            class="inline-flex items-center px-6 py-2.5 
                   {{ $redeemCode->exists ? 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 shadow-blue-400/50' : 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500 shadow-emerald-400/50' }} 
                   border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150 shadow-md focus:ring-2 focus:ring-offset-2">
            <i class="fas fa-save me-2"></i>
            {{ $redeemCode->exists ? 'Perbarui Kode' : 'Simpan Kode' }}
        </button>
        
        {{-- Tombol Batal --}}
        <a href="{{ route('admin.redeem-codes.index') }}" class="text-slate-600 hover:text-slate-800 transition duration-150 font-medium">
            Batal
        </a>
    </div>
</div>