{{-- resources/views/frontend/homepage.blade.php (Revisi Total Final: Light Mode Estetik) --}}
<x-guest-layout>
    <x-slot name="slot">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-16">
            
            {{-- Judul Utama dengan sentuhan profesional --}}
            <h2 class="text-5xl font-extrabold text-gray-900 mb-4 text-center tracking-tight leading-snug">
                Pilih Paket <span class="text-indigo-600">Canva Pro</span> Terbaik Anda ✨
            </h2>
            <p class="text-xl text-gray-600 mb-16 text-center max-w-3xl mx-auto font-light">
                Dapatkan akses penuh ke semua fitur premium dengan harga terbaik. Desain tanpa batas, mulai sekarang!
            </p>

            @if (session('error'))
                <div class="max-w-4xl mx-auto bg-red-50 border border-red-400 text-red-700 px-6 py-4 rounded-xl relative mb-10 text-center shadow-md">
                    <span class="font-bold">🚨 Kesalahan:</span> {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse ($products as $index => $product)
                
                @php
                    // KODE FUNGSIONALITAS DIBIARKAN
                    $stock = $product->available_stock; 
                    $isAvailable = $stock > 0;
                    
                    // Membuat deskripsi terlihat seperti daftar fitur
                    $features = explode("\n", strip_tags(Str::markdown($product->description)));

                    // Menentukan delay animasi dan arah slide
                    $delay = 0.1 * ($index + 1);
                    $animationClass = ($index % 2 == 0) ? 'animate-slide-up' : 'animate-slide-down';
                @endphp
                
                {{-- Struktur Kartu Produk Estetik Light Mode --}}
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden 
                            border-t-4 {{ $isAvailable ? 'border-indigo-600' : 'border-gray-300 opacity-70' }} 
                            transform {{ $isAvailable ? 'hover:scale-[1.03] hover:shadow-indigo-500/20' : '' }} 
                            transition duration-500 ease-in-out relative flex flex-col justify-between
                            {{ $animationClass }}" style="animation-delay: {{ $delay }}s; opacity: 0;">
                    
                    {{-- Badge Status di Pojok Kanan Atas --}}
                    <div class="absolute top-0 right-0 py-1 px-4 rounded-bl-2xl z-10 text-xs font-bold 
                                {{ $isAvailable ? 'bg-indigo-600 text-white' : 'bg-gray-400 text-gray-800' }}">
                        @if (!$isAvailable)
                            HABIS
                        @elseif ($stock <= 5)
                            STOK TERBATAS!
                        @else
                            READY
                        @endif
                    </div>

                    {{-- Header Kartu (Gambar atau Placeholder) --}}
                    @if ($product->image)
                        <img class="w-full h-48 object-cover object-center border-b border-gray-100" 
                             src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div class="w-full h-48 bg-indigo-50 flex items-center justify-center text-xl font-bold text-indigo-600 border-b border-gray-100">
                            <i class="fas fa-palette mr-2"></i> CANVA PRO
                        </div>
                    @endif
                    
                    <div class="p-6 flex flex-col justify-between flex-grow">
                        <div>
                            {{-- Nama Produk --}}
                            <h3 class="text-2xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                            
                            {{-- Harga Produk --}}
                            <p class="text-4xl font-black text-red-600 mb-4 mt-2">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            
                            {{-- Daftar Fitur/Deskripsi --}}
                            <div class="text-left space-y-3 border-t border-gray-100 pt-3">
                                <ul class="space-y-2 text-sm text-gray-600">
                                    @forelse (array_slice($features, 0, 3) as $feature)
                                        <li class="flex items-start">
                                            <i class="fas fa-check-circle text-indigo-500 mr-2 flex-shrink-0 mt-1"></i>
                                            <span class="font-medium">{{ Str::limit(trim($feature), 50) }}</span>
                                        </li>
                                    @empty
                                        <li class="text-sm italic text-gray-400">Deskripsi fitur belum tersedia.</li>
                                    @endforelse
                                    @if (count($features) > 3)
                                        <li class="text-sm font-semibold text-gray-500 mt-2">...dan lain-lain.</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        
                        {{-- Footer Kartu (Stok & Tombol) --}}
                        <div class="mt-6">
                            {{-- Informasi STOK --}}
                            <div class="text-center py-2 mb-4 rounded-lg {{ $isAvailable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} border border-gray-200">
                                <p class="font-semibold text-sm">
                                    Stok Kode Tersedia: <span class="font-extrabold">{{ $stock }}</span>
                                </p>
                            </div>

                            {{-- Tombol Beli --}}
                            @if ($isAvailable)
                                <a href="{{ route('product.show', $product) }}" 
                                   class="block w-full text-center py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md shadow-indigo-500/50">
                                    Beli Sekarang &rarr;
                                </a>
                            @else
                                <button disabled 
                                        class="block w-full text-center py-3 bg-gray-300 text-gray-600 font-bold rounded-lg cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    {{-- Pesan Produk Kosong (Light Mode) --}}
                    <div class="col-span-3 text-center py-16 bg-white rounded-xl shadow-2xl border border-gray-200">
                        <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                        <p class="text-2xl font-semibold text-gray-500">
                            Maaf, belum ada produk aktif yang tersedia saat ini.
                        </p>
                        <p class="text-lg text-gray-400 mt-2">Inventaris sedang diperbarui.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </x-slot>
</x-guest-layout>