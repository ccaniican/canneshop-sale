<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CanneShop Apparel - Trendiest Streetwear & Fashion Store')</title>

    <!-- Google Fonts: Plus Jakarta Sans & Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            electric: '#2563eb',
                        },
                        cool: {
                            bg: '#f8fafc',
                            card: '#ffffff',
                            border: '#e2e8f0',
                            navy: '#0f172a',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            background-color: #f8fafc;
            color: #0f172a;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 10px 30px -10px rgba(37, 99, 235, 0.08);
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 45px -12px rgba(37, 99, 235, 0.2);
            border-color: rgba(37, 99, 235, 0.4);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        .gradient-text {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .blue-glow {
            box-shadow: 0 0 35px rgba(37, 99, 235, 0.25);
        }
    </style>
    @stack('styles')
</head>
<body x-data="appState()" x-init="initApp()" class="min-h-screen flex flex-col justify-between selection:bg-blue-600 selection:text-white">

    <!-- Navigation Header (Clean White & Electric Blue) -->
    <header class="sticky top-0 z-40 glass-nav shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-700 via-blue-600 to-cyan-500 flex items-center justify-center font-display font-black text-2xl text-white shadow-lg shadow-blue-600/30 group-hover:scale-105 transition-transform">
                        C
                    </div>
                    <div>
                        <span class="font-display text-2xl font-black tracking-tight text-slate-900 group-hover:text-blue-600 transition-colors">CANNE<span class="text-blue-600">.</span>SHOP</span>
                        <span class="block text-[10px] tracking-widest text-blue-600 uppercase font-bold">Apparel & Streetwear</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-bold">
                    <a href="{{ route('home') }}#featured" class="text-blue-600 hover:text-blue-700 transition-colors flex items-center gap-1.5 font-extrabold">
                        <i data-lucide="sparkles" class="w-4 h-4 text-blue-600"></i> Katalog Trend
                    </a>
                    <a href="{{ route('home') }}?category=oversized-hoodies #katalog" class="text-slate-600 hover:text-blue-600 transition-colors">Hoodies</a>
                    <a href="{{ route('home') }}?category=streetwear-tshirts #katalog" class="text-slate-600 hover:text-blue-600 transition-colors">T-Shirts</a>
                    <a href="{{ route('home') }}?category=jackets-outerwear #katalog" class="text-slate-600 hover:text-blue-600 transition-colors">Jackets</a>
                    <a href="{{ route('home') }}?category=pants-cargo #katalog" class="text-slate-600 hover:text-blue-600 transition-colors">Cargo Pants</a>
                </nav>

                <!-- Actions: Auth Status, Admin Toggle & Cart Drawer Trigger -->
                <div class="flex items-center gap-3">
                    
                    @auth
                        @if(Auth::user()->isAdmin())
                            <!-- Admin Panel Quick Link -->
                            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold px-3.5 py-2.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 transition-all flex items-center gap-1.5 shadow-sm">
                                <i data-lucide="shield" class="w-4 h-4 text-blue-600"></i>
                                <span>Panel Admin</span>
                            </a>
                        @endif

                        <!-- User Profile Link Badge -->
                        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 bg-slate-100/80 hover:bg-slate-200/80 px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold transition-all" title="Buka Dashboard Akun Saya">
                            <i data-lucide="user-check" class="w-4 h-4 text-blue-600"></i>
                            <span class="text-slate-800">{{ Auth::user()->name }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase {{ Auth::user()->isAdmin() ? 'bg-blue-600 text-white' : 'bg-cyan-500 text-white' }}">
                                {{ Auth::user()->role }}
                            </span>
                        </a>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 transition-all shadow-sm" title="Keluar (Logout)">
                                <i data-lucide="log-out" class="w-4.5 h-4.5"></i>
                            </button>
                        </form>
                    @else
                        <!-- Guest Login & Register Buttons -->
                        <a href="{{ route('login') }}" class="text-xs font-extrabold px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 transition-all shadow-sm flex items-center gap-1">
                            <i data-lucide="log-in" class="w-4 h-4 text-blue-600"></i>
                            <span>Masuk</span>
                        </a>
                        <a href="{{ route('register') }}" class="text-xs font-extrabold px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition-all shadow-md shadow-blue-600/30 flex items-center gap-1">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            <span>Daftar</span>
                        </a>
                    @endauth

                    <!-- Cart Drawer Button -->
                    <button @click="cartDrawerOpen = true" class="relative p-2.5 rounded-xl bg-white hover:bg-blue-50 text-slate-800 border border-slate-200 transition-all flex items-center justify-center shadow-sm group">
                        <i data-lucide="shopping-bag" class="w-5 h-5 text-blue-600 group-hover:scale-110 transition-transform"></i>
                        <span x-show="cartData.total_items > 0" 
                              x-text="cartData.total_items" 
                              class="absolute -top-1.5 -right-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-black text-[10px] w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-md">
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-2xl flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
                        <span class="font-semibold text-sm">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if(session('warning') || session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-2xl flex items-center gap-2 shadow-md">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600"></i>
                    <span class="font-semibold text-sm">{{ session('warning') ?: session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Slide-over Cart Drawer Component (Fresh White & Royal Blue) -->
    <div x-show="cartDrawerOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-hidden" 
         style="display: none;">
        
        <!-- Backdrop -->
        <div @click="cartDrawerOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-md bg-white border-l border-slate-200 text-slate-800 shadow-2xl flex flex-col justify-between">
                
                <!-- Drawer Header -->
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/80">
                    <div class="flex items-center gap-2">
                        <i data-lucide="shopping-cart" class="w-5 h-5 text-blue-600"></i>
                        <h2 class="font-display font-black text-lg text-slate-900">Keranjang Gaul Anda</h2>
                        <span class="text-xs text-blue-600 font-bold" x-text="'(' + (cartData.total_items || 0) + ' item)'"></span>
                    </div>
                    <button @click="cartDrawerOpen = false" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-900 hover:bg-slate-200 transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Cart Items List -->
                <div class="flex-grow overflow-y-auto p-5 space-y-4 custom-scrollbar">
                    <template x-if="!cartData.cart || cartData.cart.length === 0">
                        <div class="text-center py-16 text-slate-400 space-y-3">
                            <div class="w-16 h-16 rounded-3xl bg-blue-50 mx-auto flex items-center justify-center text-blue-500">
                                <i data-lucide="shopping-bag" class="w-8 h-8"></i>
                            </div>
                            <p class="font-bold text-sm text-slate-800">Keranjang Masih Kosong Bro!</p>
                            <p class="text-xs text-slate-500">Pilih apparel paling hits di katalog dan checkout sekarang!</p>
                        </div>
                    </template>

                    <template x-for="item in cartData.cart" :key="item.key">
                        <div class="bg-slate-50/80 rounded-2xl p-3.5 border border-slate-200 flex gap-3 items-center shadow-sm">
                            <img :src="item.image" :alt="item.name" class="w-16 h-16 rounded-xl object-cover bg-white border border-slate-200">
                            <div class="flex-grow min-w-0">
                                <h4 class="font-bold text-sm text-slate-900 truncate" x-text="item.name"></h4>
                                <div class="text-xs text-slate-500 flex items-center gap-2 mt-0.5">
                                    <span>Size: <strong class="text-blue-600 font-extrabold" x-text="item.size"></strong></span>
                                    <span>•</span>
                                    <span class="font-semibold text-slate-700" x-text="item.formatted_price"></span>
                                </div>
                                
                                <!-- Quantity Adjuster -->
                                <div class="flex items-center gap-2 mt-2">
                                    <button @click="updateCartItem(item.key, item.quantity - 1)" class="w-6 h-6 rounded-lg bg-white border border-slate-300 hover:bg-blue-50 flex items-center justify-center text-xs font-bold text-slate-700">-</button>
                                    <span class="text-xs font-extrabold px-2 text-slate-900" x-text="item.quantity"></span>
                                    <button @click="updateCartItem(item.key, item.quantity + 1)" class="w-6 h-6 rounded-lg bg-white border border-slate-300 hover:bg-blue-50 flex items-center justify-center text-xs font-bold text-slate-700">+</button>
                                </div>
                            </div>
                            <button @click="removeCartItem(item.key)" class="p-2 text-slate-400 hover:text-rose-600 transition-colors">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </template>
                </div>

                <!-- Drawer Footer & Checkout -->
                <div x-show="cartData.cart && cartData.cart.length > 0" class="p-5 border-t border-slate-100 bg-white space-y-3 shadow-lg">
                    
                    <!-- Coupon Input -->
                    <div class="flex gap-2">
                        <input type="text" x-model="couponCode" placeholder="Kode Promo (CANNE10)" class="flex-grow bg-slate-50 text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 font-bold uppercase">
                        <button @click="applyCouponCode()" class="bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-extrabold px-4 py-2.5 rounded-xl border border-blue-200 transition-colors">
                            Pakai
                        </button>
                    </div>

                    <div class="space-y-1.5 text-xs text-slate-600 pt-2 border-t border-slate-100">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Subtotal:</span>
                            <span class="font-bold text-slate-800" x-text="cartData.formatted_subtotal"></span>
                        </div>
                        <template x-if="cartData.discount > 0">
                            <div class="flex justify-between text-emerald-600 font-bold">
                                <span>Diskon Promo:</span>
                                <span x-text="'- ' + cartData.formatted_discount"></span>
                            </div>
                        </template>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Estimasi Ongkir:</span>
                            <span class="font-bold text-slate-800" x-text="cartData.formatted_shipping"></span>
                        </div>
                        <div class="flex justify-between font-black text-base text-slate-900 pt-2 border-t border-slate-200">
                            <span>Total Tagihan:</span>
                            <span class="text-blue-600" x-text="cartData.formatted_grand_total"></span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="w-full bg-gradient-to-r from-blue-600 via-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-extrabold py-3.5 rounded-xl shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2 transition-all transform hover:-translate-y-0.5">
                        <span>Lanjut Checkout</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Quick View Modal (White & Electric Blue Theme) -->
    <div x-show="quickViewModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4"
         style="display: none;">
        
        <div @click="quickViewModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>

        <div class="relative glass-panel bg-white border border-slate-200 rounded-3xl max-w-3xl w-full p-6 text-slate-900 overflow-hidden shadow-2xl z-10" @click.stop>
            <button @click="quickViewModalOpen = false" class="absolute top-4 right-4 p-2 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-900 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <template x-if="modalProduct">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <img :src="modalProduct.image" :alt="modalProduct.name" class="w-full h-80 object-cover rounded-2xl border border-slate-200 shadow-md">
                    </div>
                    <div class="flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-extrabold text-blue-600 tracking-widest uppercase" x-text="modalProduct.category ? modalProduct.category.name : 'Apparel'"></span>
                            <h2 class="text-2xl font-black font-display text-slate-900 mt-1" x-text="modalProduct.name"></h2>
                            
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex text-amber-400">
                                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-700" x-text="modalProduct.rating"></span>
                                <span class="text-xs text-slate-400" x-text="'(' + modalProduct.review_count + ' ulasan)'"></span>
                            </div>

                            <div class="mt-4 flex items-baseline gap-3">
                                <span class="text-2xl font-black text-blue-600" x-text="'Rp ' + Number(modalProduct.discount_price || modalProduct.price).toLocaleString('id-ID')"></span>
                                <template x-if="modalProduct.discount_price">
                                    <span class="text-sm text-slate-400 line-through font-semibold" x-text="'Rp ' + Number(modalProduct.price).toLocaleString('id-ID')"></span>
                                </template>
                            </div>

                            <p class="text-xs text-slate-600 mt-3 leading-relaxed" x-text="modalProduct.description"></p>

                            <!-- Size Selector -->
                            <div class="mt-4">
                                <label class="block text-xs font-bold text-slate-700 mb-2">Pilih Ukuran (Size):</label>
                                <div class="flex gap-2">
                                    <template x-for="sz in (modalProduct.sizes || ['S', 'M', 'L', 'XL'])" :key="sz">
                                        <button @click="selectedSize = sz" 
                                                :class="selectedSize === sz ? 'bg-blue-600 text-white border-blue-600 shadow-md shadow-blue-600/30' : 'bg-slate-100 text-slate-700 border-slate-200 hover:border-blue-400'" 
                                                class="px-4 py-2 rounded-xl text-xs font-black border transition-all" 
                                                x-text="sz">
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Add to Cart Buttons -->
                        <div class="mt-6 flex gap-3">
                            <button @click="addToCart(modalProduct.id, 1, selectedSize); quickViewModalOpen = false;" class="flex-grow bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3.5 rounded-xl shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2 text-sm transition-all">
                                <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                <span>+ Tambah ke Keranjang</span>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Footer Section (White & Navy) -->
    <footer class="bg-white border-t border-slate-200 pt-12 pb-8 text-slate-600 text-sm mt-16 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-12 border-b border-slate-200">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center font-black text-white text-xl shadow-md">C</div>
                        <span class="font-display text-xl font-black text-slate-900">CANNE<span class="text-blue-600">.</span>SHOP</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Toko apparel & streetwear resmi dengan kualitas katun fleece premium, potongan oversized eksklusif, serta garansi 100% original.
                    </p>
                </div>
                <div>
                    <h5 class="font-extrabold text-slate-900 text-sm mb-3">Kategori Produk</h5>
                    <ul class="space-y-2 text-xs font-semibold">
                        <li><a href="{{ route('home') }}?category=oversized-hoodies" class="hover:text-blue-600 transition-colors">Oversized Hoodies</a></li>
                        <li><a href="{{ route('home') }}?category=streetwear-tshirts" class="hover:text-blue-600 transition-colors">Streetwear T-Shirts</a></li>
                        <li><a href="{{ route('home') }}?category=jackets-outerwear" class="hover:text-blue-600 transition-colors">Jackets & Outerwear</a></li>
                        <li><a href="{{ route('home') }}?category=pants-cargo" class="hover:text-blue-600 transition-colors">Tactical Cargo Pants</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-extrabold text-slate-900 text-sm mb-3">Layanan Pelanggan</h5>
                    <ul class="space-y-2 text-xs font-semibold">
                        <li><a href="#" class="hover:text-blue-600 transition-colors">Tracking Pesanan Realtime</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">Panduan Ukuran Baju</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">Kebijakan Retur & Penukaran</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">Konfirmasi Pembayaran QRIS</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-extrabold text-slate-900 text-sm mb-3">Metode Pembayaran</h5>
                    <div class="flex flex-wrap gap-2 text-xs font-bold text-slate-700">
                        <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200">QRIS Instan</span>
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200">BCA Virtual Account</span>
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200">Mandiri VA</span>
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200">COD Bayar di Tempat</span>
                    </div>
                </div>
            </div>
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-slate-400 font-semibold gap-4">
                <p>&copy; 2026 CanneShop Apparel. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-blue-600">Privacy Policy</a>
                    <a href="#" class="hover:text-blue-600">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine App State Logic -->
    <script>
        function appState() {
            return {
                cartDrawerOpen: false,
                quickViewModalOpen: false,
                modalProduct: null,
                selectedSize: 'M',
                couponCode: '',
                cartData: {
                    cart: [],
                    total_items: 0,
                    formatted_subtotal: 'Rp 0',
                    formatted_discount: 'Rp 0',
                    formatted_shipping: 'Rp 15.000',
                    formatted_grand_total: 'Rp 0',
                    discount: 0
                },
                initApp() {
                    this.fetchCart();
                    this.$nextTick(() => {
                        lucide.createIcons();
                    });
                },
                fetchCart() {
                    fetch('{{ route("cart.index") }}')
                        .then(res => res.json())
                        .then(data => {
                            this.cartData = data;
                            this.$nextTick(() => lucide.createIcons());
                        })
                        .catch(err => console.error(err));
                },
                addToCart(productId, quantity = 1, size = 'M') {
                    fetch('{{ route("cart.add") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ product_id: productId, quantity: quantity, size: size })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.fetchCart();
                        this.cartDrawerOpen = true;
                    });
                },
                updateCartItem(key, newQty) {
                    if (newQty < 1) {
                        this.removeCartItem(key);
                        return;
                    }
                    fetch('{{ route("cart.update") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ key: key, quantity: newQty })
                    })
                    .then(res => res.json())
                    .then(() => this.fetchCart());
                },
                removeCartItem(key) {
                    fetch('{{ route("cart.remove") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ key: key })
                    })
                    .then(res => res.json())
                    .then(() => this.fetchCart());
                },
                applyCouponCode() {
                    if (!this.couponCode) return;
                    fetch('{{ route("cart.coupon") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ code: this.couponCode })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert(data.message);
                            this.fetchCart();
                        } else {
                            alert(data.message || 'Kupon tidak valid');
                        }
                    });
                },
                openQuickView(productId) {
                    fetch('{{ url("product") }}/' + productId)
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                this.modalProduct = data.product;
                                this.selectedSize = (data.product.sizes && data.product.sizes.length > 0) ? data.product.sizes[0] : 'M';
                                this.quickViewModalOpen = true;
                                this.$nextTick(() => lucide.createIcons());
                            }
                        });
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
