<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-slate-800 leading-tight flex items-center">
            <i class="fas fa-pencil-alt text-emerald-600 me-3"></i>
            {{ __('Edit Kode Redeem: ') }}
            <span class="font-mono text-emerald-600 ml-1">{{ $redeemCode->code }}</span>
        </h2>
    </x-slot>

    <div class="py-8 lg:py-10 bg-gray-50">
        {{-- Menggunakan lebar max-w-3xl agar form terlihat ringkas --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Card Formulir Utama: Mewah dan Terstruktur --}}
            <div class="bg-white shadow-2xl rounded-xl p-6 sm:p-8 border-t-4 border-blue-500">
                
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
                    Perbarui Status dan Detail Kode
                </h3>

                {{-- Formulir Edit --}}
                <form method="POST" action="{{ route('admin.redeem-codes.update', $redeemCode) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    {{-- 🛑 Panggil form parsial 🛑 --}}
                    @include('admin.redeem_codes._form', ['redeemCode' => $redeemCode, 'products' => $products])
                </form>

            </div>
        </div>
    </div>
</x-app-layout>