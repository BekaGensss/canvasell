<nav x-data="{ open: false }" class="bg-slate-800 border-b border-gray-700 shadow-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Logo (Mengarah ke Homepage) --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('homepage') }}">
                        {{-- Logo Putih dengan Aksen Emerald --}}
                        <h1 class="text-2xl font-extrabold text-white hover:text-gray-300 transition tracking-tight">
                            Canva<span class="text-emerald-400">Sell</span>
                        </h1>
                    </a>
                </div>

                {{-- 🛑 LINK NAVIGASI UTAMA (Desktop) 🛑 --}}
                <div class="hidden space-x-2 sm:-my-px sm:ms-8 sm:flex items-center">
                    
                    {{-- Link Home Toko (Teks Putih) --}}
                    <x-nav-link :href="route('homepage')" :active="request()->routeIs('homepage')" 
                                class="!px-3 !py-2 text-sm font-medium text-gray-300 hover:text-emerald-400 hover:bg-slate-700 rounded-lg transition duration-150">
                        <i class="fas fa-store me-1"></i> {{ __('Home Toko') }}
                    </x-nav-link>

                    {{-- LINK ADMIN PANEL DENGAN IKON (Teks Putih/Kontras) --}}
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        {{-- Dashboard --}}
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                                    class="!px-3 !py-2 text-sm font-medium text-white hover:text-white hover:bg-emerald-600 rounded-lg transition duration-150 transform hover:scale-[1.02] shadow-sm">
                            <i class="fas fa-gauge me-1"></i> {{ __('Dashboard') }}
                        </x-nav-link>
                        {{-- Kelola Produk --}}
                        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')"
                                    class="!px-3 !py-2 text-sm font-medium text-white hover:text-white hover:bg-emerald-600 rounded-lg transition duration-150 transform hover:scale-[1.02] shadow-sm">
                            <i class="fas fa-boxes-stacked me-1"></i> {{ __('Produk') }}
                        </x-nav-link>
                        {{-- Kelola Kode Redeem --}}
                        <x-nav-link :href="route('admin.redeem-codes.index')" :active="request()->routeIs('admin.redeem-codes.*')"
                                    class="!px-3 !py-2 text-sm font-medium text-white hover:text-white hover:bg-emerald-600 rounded-lg transition duration-150 transform hover:scale-[1.02] shadow-sm">
                            <i class="fas fa-key me-1"></i> {{ __('Kode Redeem') }}
                        </x-nav-link>
                        {{-- Pemesanan --}}
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')"
                                    class="!px-3 !py-2 text-sm font-medium text-white hover:text-white hover:bg-emerald-600 rounded-lg transition duration-150 transform hover:scale-[1.02] shadow-sm">
                            <i class="fas fa-receipt me-1"></i> {{ __('Pemesanan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            {{-- Dropdown Pengguna (Kanan Atas) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-slate-700 hover:text-white hover:bg-slate-700 focus:outline-none transition ease-in-out duration-150">
                            {{-- Tambah Ikon User/Avatar --}}
                            <i class="fas fa-user-circle me-2 text-lg text-emerald-400"></i>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Link Profil --}}
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-address-card me-2"></i> {{ __('Profile') }}
                        </x-dropdown-link>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt me-2 text-red-500"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Toggle Mobile (Diubah ke dark) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-slate-700 focus:outline-none focus:bg-slate-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu Responsif (Mobile) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-800">
        <div class="pt-2 pb-3 space-y-1">
            {{-- Link Home (Default untuk Mobile) --}}
            <x-responsive-nav-link :href="route('homepage')" :active="request()->routeIs('homepage')" class="text-gray-300 hover:bg-slate-700">
                <i class="fas fa-store me-2"></i> {{ __('Home Toko') }}
            </x-responsive-nav-link>

            {{-- Link Admin Panel (Responsive) --}}
            @if (Auth::check() && Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:bg-emerald-600">
                    <i class="fas fa-gauge me-2"></i> {{ __('Admin Panel') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')" class="text-white hover:bg-emerald-600">
                    <i class="fas fa-boxes-stacked me-2"></i> {{ __('Kelola Produk') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.redeem-codes.index')" :active="request()->routeIs('admin.redeem-codes.*')" class="text-white hover:bg-emerald-600">
                    <i class="fas fa-key me-2"></i> {{ __('Kelola Kode Redeem') }}
                </x-responsive-nav-link>
                 <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" class="text-white hover:bg-emerald-600">
                    <i class="fas fa-receipt me-2"></i> {{ __('Pemesanan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>