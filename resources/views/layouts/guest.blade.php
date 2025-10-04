{{-- resources/views/layouts/guest.blade.php (Final Estetik: Header Navy Kontras) --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CanvaSell - Beli Canva Pro Fitur Lengkap | Akses Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />
        
        {{-- 🛑 FIX: Menghapus 'integrity' untuk mencegah error CDN --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { 
                overflow-x: hidden; 
                /* Tambahkan latar belakang bertekstur/gradien halus untuk estetika */
                background-color: #f7f8fa; 
                background-image: radial-gradient(#d3d3d3 1px, transparent 0);
                background-size: 20px 20px;
            }

            .main-content { 
                padding-bottom: 4rem;
            }
        </style>
    </head>
    
    <body class="font-sans antialiased flex flex-col min-h-screen">

        {{-- 🛑 HEADER SANGAT KONTRAS (DEEP NAVY) --}}
        <header class="bg-slate-800 shadow-xl w-full z-20 sticky top-0"> 
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                
                {{-- Logo dengan warna terang/kontras --}}
                <a href="{{ route('homepage') }}" class="text-3xl font-extrabold text-white hover:text-gray-300 transition tracking-tight">
                    Canva<span class="text-emerald-400">Sell</span>
                </a>
                
                <nav class="flex items-center space-x-6">
                    <a href="{{ route('homepage') }}" class="text-gray-300 hover:text-emerald-400 font-medium transition text-sm uppercase p-2">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                    
                    @if (!Auth::check())
                        {{-- Tombol Login Admin Kontras --}}
                        <a href="{{ route('login') }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition text-sm font-bold shadow-lg shadow-emerald-400/50 transform hover:scale-[1.02]">
                            <i class="fas fa-user-lock me-1"></i> ADMIN LOGIN
                        </a>
                    @endif
                </nav>
            </div>
        </header>

        {{-- Main Content: Flex-1, Centering sempurna --}}
        <main class="main-content flex-1 flex items-center justify-center p-6"> 
            {{ $slot }}
        </main>
        
        {{-- 🛑 FOOTER KONTRAS DENGAN LATAR BELAKANG --}}
        <footer class="py-5 text-center text-xs border-t-2 border-slate-200 bg-slate-100 shadow-inner">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-sm text-slate-700 mb-1 font-semibold">
                    Solusi Cepat untuk Akses Premium Canva.
                </p>
                <p class="text-xs text-slate-500">
                    &copy; {{ date('Y') }} CanvaSell. All rights reserved. | Dibuat dengan Laravel & Tailwind CSS.
                </p>
            </div>
        </footer>
        
    </body>
</html>