<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-slate-800 leading-tight flex items-center">
            <i class="fas fa-edit text-emerald-600 me-3"></i>
            {{ __('Edit Produk: ') }}<span class="text-emerald-600">{{ $product->name }}</span>
        </h2>
    </x-slot>

    <div class="py-8 lg:py-10 bg-gray-50">
        {{-- Menggunakan lebar max-w-3xl agar lebih ringkas --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Card Formulir Utama: Mewah dan Terstruktur --}}
            <div class="bg-white shadow-2xl rounded-xl p-6 sm:p-8 border-t-4 border-blue-500">
                
                {{-- Tombol Kembali (Navigasi) --}}
                <div class="mb-6 flex justify-start">
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-slate-800 transition duration-150 p-2 rounded-lg bg-gray-50 hover:bg-gray-100 border border-gray-200">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Daftar Produk
                    </a>
                </div>
                
                {{-- Judul Card --}}
                <h3 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-3">
                    Perbarui Data Produk
                </h3>

                {{-- Formulir Edit --}}
                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    {{-- 🛑 Ini adalah include file _form Anda 🛑 --}}
                    @include('admin.products._form', ['product' => $product])
                </form>

            </div>
        </div>
    </div>
</x-app-layout>