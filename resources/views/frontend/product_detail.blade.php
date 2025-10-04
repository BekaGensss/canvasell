{{-- resources/views/frontend/product_detail.blade.php --}}
<x-guest-layout>
    <x-slot name="slot">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-8">
            <a href="{{ route('homepage') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 mb-6 inline-block">&larr; Kembali ke Daftar Produk</a>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Bagian Kiri: Detail Produk --}}
                <div class="md:col-span-2">
                    @if ($product->image)
                        <img class="w-full h-80 object-cover rounded-lg mb-6 shadow-md" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                    @endif
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ $product->name }}</h1>
                    <p class="text-5xl font-extrabold text-red-600 dark:text-red-400 mb-6">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    <div class="prose max-w-none dark:prose-invert text-gray-600 dark:text-gray-300 leading-relaxed">
                        {!! Str::markdown($product->description ?? 'Deskripsi produk belum diisi.') !!}
                    </div>
                </div>

                {{-- Bagian Kanan: Form Pemesanan Tanpa Login --}}
                <div class="md:col-span-1 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-inner sticky top-24 self-start">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 border-b pb-3">Lengkapi Data Order</h2>
                    
                    {{-- Error Validation --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm">
                            <strong class="font-bold">Gagal!</strong>
                            <ul class="mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {{-- Form Order Store --}}
                    <form action="{{ route('order.store') }}" method="POST" class="space-y-4">
                        @csrf
                        {{-- Hidden Product ID --}}
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        {{-- Input Nama Lengkap --}}
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            @error('customer_name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- Input Email --}}
                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email (Penerima Kode)</label>
                            <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            <p class="mt-1 text-xs text-gray-500">Kode redeem akan dikirimkan ke email ini.</p>
                            @error('customer_email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Input Nomor WhatsApp --}}
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor WhatsApp</label>
                            <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            @error('customer_phone') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-4 mt-4 border-t dark:border-gray-600">
                            <p class="text-xl font-bold text-gray-900 dark:text-white">Total Harga:</p>
                            <p class="text-4xl font-extrabold text-red-600 dark:text-red-400">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        
                        {{-- Tombol Submit --}}
                        <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition duration-150 shadow-lg">
                            Lanjutkan ke Pembayaran
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </x-slot>
</x-guest-layout>