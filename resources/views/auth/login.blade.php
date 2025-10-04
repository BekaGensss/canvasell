{{-- resources/views/auth/login.blade.php (Menggunakan Ikon SVG Gembok yang Aman dari CDN) --}}
<x-guest-layout>
    {{-- Container Card: max-w-sm (384px) --}}
    <div class="w-full max-w-sm mx-auto p-4 md:p-0"> 
        
        {{-- Card Utama: Clean, Kontras, Rounded Minimalis --}}
        <div class="auth-form-container bg-white rounded-xl p-8 shadow-2xl transition-all duration-300 relative overflow-hidden z-10 border-t-8 border-emerald-500">
            
            {{-- Header/Judul Login --}}
            <div class="text-center mb-10 animate-slide-down" style="animation-delay: 0.1s; opacity: 0;">
                
                {{-- Ikon Gembok (MENGGUNAKAN SVG, Tidak Bergantung CDN Font Awesome) --}}
                <div class="mb-5 p-3 inline-block bg-emerald-50 rounded-full shadow-inner shadow-emerald-100">
                    <svg class="w-8 h-8 text-emerald-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 1.5a6.5 6.5 0 00-6.5 6.5v2h13v-2A6.5 6.5 0 0012 1.5zm-5 6.5a5 5 0 0110 0v2H7v-2zM4 12v9a2 2 0 002 2h12a2 2 0 002-2v-9H4zm14 9H6v-7h12v7zM12 15a1 1 0 011 1v2a1 1 0 01-2 0v-2a1 1 0 011-1z"/>
                    </svg>
                </div>
                
                <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
                    Portal <span class="text-emerald-600">Login</span>
                </h1>
                <p class="text-slate-500 mt-2 text-sm font-light">
                    Masuk ke dasbor Anda dengan akun yang terdaftar.
                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-3 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 font-medium text-sm rounded-md animate-slide-down" style="animation-delay: 0.2s; opacity: 0;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email Address Field --}}
                <div class="mb-5 animate-slide-up" style="animation-delay: 0.3s; opacity: 0;">
                    <label for="email" class="block font-semibold text-slate-700 mb-2 text-sm">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <input
                            id="email" 
                            class="block w-full py-3 px-4 border border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500/50 placeholder-gray-500 transition duration-200 text-base shadow-sm" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username" 
                            placeholder="cth: admin@domain.com"
                        />
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div class="mb-6 animate-slide-up" style="animation-delay: 0.4s; opacity: 0;">
                    <label for="password" class="block font-semibold text-slate-700 mb-2 text-sm">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input
                            id="password" 
                            class="block w-full py-3 px-4 border border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500/50 placeholder-gray-500 transition duration-200 text-base shadow-sm"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password" 
                            placeholder="Masukkan kata sandi Anda"
                        />
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me & Forgot Password --}}
                <div class="flex justify-between items-center mb-8 animate-slide-up" style="animation-delay: 0.5s; opacity: 0;">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 transition duration-150 w-4 h-4" name="remember">
                        <span class="ms-2 text-sm text-slate-600 font-medium">Ingat Saya</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition duration-150 hover:underline" 
                            href="{{ route('password.request') }}">
                            Lupa Kata Sandi?
                        </a>
                    @endif
                </div>

                {{-- Tombol Login (Kontras Emerald) --}}
                <div class="animate-slide-up" style="animation-delay: 0.6s; opacity: 0;">
                    <button type="submit" class="w-full text-center py-3.5 bg-emerald-600 text-white text-lg font-bold rounded-lg
                                                 hover:bg-emerald-700 transition duration-300 focus:ring-4 focus:ring-emerald-300/70 
                                                 shadow-xl shadow-emerald-400/50 transform hover:scale-[1.01] flex items-center justify-center">
                        <i class="fas fa-sign-in-alt me-2 text-xl"></i>
                        MASUK SEKARANG
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</x-guest-layout>