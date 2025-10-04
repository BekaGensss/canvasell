<x-app-layout>
    
    {{-- Header Dashboard Baru (Judul Halaman) --}}
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-slate-800 leading-tight flex items-center">
            <i class="fas fa-chart-line text-emerald-600 me-3"></i>
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    {{-- CONTAINER UTAMA: Light Mode --}}
    <div class="py-8 lg:py-12 bg-white"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Bagian 1: Selamat Datang (Hero Card) --}}
            <div class="bg-white p-8 shadow-2xl rounded-xl border-l-4 border-emerald-500 mb-10 transform hover:shadow-3xl transition duration-300">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
                    
                    <div class="mb-6 md:mb-0">
                        <h3 class="text-3xl font-bold text-slate-900 mb-2">
                            Selamat Datang, <span class="text-emerald-600">{{ Auth::user()->name ?? 'Admin' }}!</span>
                        </h3>
                        <p class="text-slate-600 text-md">
                            Ini adalah panel kontrol utama Anda. Semua metrik dan tindakan cepat ada di sini.
                        </p>
                    </div>

                    {{-- Status/Ikon Visual --}}
                    <div class="text-4xl text-emerald-500 hidden sm:block">
                        <i class="fas fa-lock text-5xl"></i>
                    </div>

                </div>
            </div>

            {{-- Bagian 2: Tindakan Cepat (Card Grid) --}}
            <h3 class="text-xl font-bold text-slate-800 mb-5">Tindakan Cepat</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- CARD: KELOLA PRODUK CANVA (Aksen Biru) --}}
                <a href="{{ route('admin.products.index') }}" 
                   class="dashboard-card bg-white p-6 rounded-xl shadow-lg border border-gray-100 
                          hover:shadow-xl hover:border-blue-500 transition duration-300 group">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-boxes text-3xl text-blue-500 group-hover:scale-110 transition"></i>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Utama</p>
                            <h4 class="text-xl font-extrabold text-slate-800">Kelola Produk</h4>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-slate-500">Tambah, edit, atau hapus daftar produk Canva Pro.</p>
                </a>
                
                {{-- CARD: KELOLA KODE REDEEM (Aksen Hijau/Emerald) --}}
                <a href="{{ route('admin.redeem-codes.index') }}" 
                   class="dashboard-card bg-white p-6 rounded-xl shadow-lg border border-gray-100 
                          hover:shadow-xl hover:border-emerald-500 transition duration-300 group">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-key text-3xl text-emerald-500 group-hover:scale-110 transition"></i>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Inventaris</p>
                            <h4 class="text-xl font-extrabold text-slate-800">Kelola Kode Redeem</h4>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-slate-500">Kelola daftar kode yang tersedia, termasuk impor massal.</p>
                </a>
                
                {{-- CARD: LIHAT PEMESANAN (Aksen Oranye) --}}
                <a href="{{ route('admin.orders.index') }}" 
                   class="dashboard-card bg-white p-6 rounded-xl shadow-lg border border-gray-100 
                          hover:shadow-xl hover:border-orange-500 transition duration-300 group">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-receipt text-3xl text-orange-500 group-hover:scale-110 transition"></i>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Transaksi</p>
                            <h4 class="text-xl font-extrabold text-slate-800">Lihat Pemesanan</h4>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-slate-500">Monitor status pembayaran dan pengiriman semua order masuk.</p>
                </a>
                
            </div>
            
            {{-- Bagian 3: Statistik Ringkas (Sekarang dengan HTML Card dan Variabel Dinamis) --}}
            <h3 class="text-xl font-bold text-slate-800 mt-10 mb-5">Statistik Ringkas</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- METRIC 1: Total Orders --}}
                <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-blue-500">
                    <p class="text-sm font-medium text-slate-500">Total Orders</p>
                    <h5 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalOrders }}</h5>
                </div>

                {{-- METRIC 2: Total Revenue (Bulan Ini) --}}
                <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-green-500">
                    <p class="text-sm font-medium text-slate-500">Revenue (Bulan Ini)</p>
                    <h5 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $revenue }}</h5>
                </div>
                
                {{-- METRIC 3: Stock Redeem Codes --}}
                <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-yellow-500">
                    <p class="text-sm font-medium text-slate-500">Stok Kode Tersedia</p>
                    <h5 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stockAvailable }}</h5>
                </div>
                
                {{-- METRIC 4: Pending Orders --}}
                <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-red-500">
                    <p class="text-sm font-medium text-slate-500">Pemesanan Tertunda</p>
                    <h5 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $pendingOrders }}</h5>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>