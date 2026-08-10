@extends('layouts.app')

@section('title', 'CanneShop Apparel - Trendiest Streetwear & Official Store')

@section('content')

<!-- Hero Banner Section (Clean White & Electric Blue Theme) -->
<section class="relative overflow-hidden pt-8 pb-16 lg:py-20 bg-gradient-to-b from-blue-50/60 via-white to-slate-50 border-b border-slate-200">
    <!-- Soft Ambient Lighting -->
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[400px] bg-blue-400/20 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute top-10 right-10 w-[350px] h-[350px] bg-cyan-400/15 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-left">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-100/90 border border-blue-300 text-blue-800 text-xs font-black tracking-wide shadow-sm">
                    <i data-lucide="zap" class="w-4 h-4 text-blue-600 fill-current"></i>
                    <span>STREETWEAR TRENDING 2026</span>
                </div>

                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.1]">
                    Tampil Lebih Gaul & <br>
                    <span class="gradient-text">
                        Styling Hypebeast
                    </span>
                </h1>

                <p class="text-slate-600 text-base sm:text-lg leading-relaxed max-w-2xl font-medium">
                    Koleksi pakaian, hoodie oversized, dan cargo pants dengan potongan fit kekinian. Bahan Heavyweight Cotton Fleece 330gsm & washed aesthetic paling hits!
                </p>

                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="#katalog" class="bg-gradient-to-r from-blue-600 via-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-extrabold px-8 py-4 rounded-2xl shadow-xl shadow-blue-600/30 flex items-center gap-2 transition-all transform hover:-translate-y-1">
                        <span>Cari Apparel Gaul</span>
                        <i data-lucide="arrow-down-right" class="w-5 h-5"></i>
                    </a>
                    <a href="#featured" class="bg-white hover:bg-slate-50 text-slate-800 font-bold px-7 py-4 rounded-2xl border border-slate-300 shadow-sm transition-all flex items-center gap-2">
                        <i data-lucide="flame" class="w-4 h-4 text-amber-500 fill-current"></i>
                        <span>Produk Bestseller</span>
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="pt-6 border-t border-slate-200 grid grid-cols-3 gap-4 text-left">
                    <div>
                        <h4 class="font-display font-black text-2xl text-blue-700">100%</h4>
                        <p class="text-xs text-slate-500 font-bold">Cotton Fleece Premium</p>
                    </div>
                    <div>
                        <h4 class="font-display font-black text-2xl text-blue-700">15K+</h4>
                        <p class="text-xs text-slate-500 font-bold">Anak Gaul Terpuaskan</p>
                    </div>
                    <div>
                        <h4 class="font-display font-black text-2xl text-blue-700">Fast</h4>
                        <p class="text-xs text-slate-500 font-bold">Kirim 1 Hari Sampai</p>
                    </div>
                </div>
            </div>

            <!-- Right Featured Image Cards Showcase -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    
                    <!-- Main Card -->
                    <div class="glass-panel p-4 rounded-3xl border border-slate-200 shadow-2xl relative z-10 group overflow-hidden bg-white">
                        <img src="{{ url('images/products/home.jpg') }}" alt="Featured Apparel" class="w-full h-[390px] object-cover rounded-2xl group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute bottom-6 left-6 right-6 p-4 rounded-2xl bg-white/95 backdrop-blur-md border border-slate-200 shadow-xl flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">⚡ PALING HITS</span>
                                <h3 class="font-black text-base text-slate-900">Stussy Dover Street Market T-Shirt</h3>
                                <p class="text-xs text-blue-600 font-black mt-0.5">Rp 329.000 <span class="text-slate-400 line-through text-[11px] font-semibold">Rp 389.000</span></p>
                            </div>
                            <button @click="openQuickView(5)" class="p-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-600/30 transition-all">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Floating Badge Card -->
                    <div class="hidden sm:flex absolute -top-4 -left-6 z-20 bg-white border border-blue-200 p-3.5 rounded-2xl shadow-xl items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-900">Rating 4.9 / 5.0</p>
                            <p class="text-[10px] text-slate-500 font-semibold">Ulasan Anak Muda Indo</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Featured Bestsellers Carousel / Highlights -->
<section id="featured" class="py-12 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4">
            <div>
                <span class="text-xs font-black text-blue-600 uppercase tracking-widest">HYPEBEAST CHOICE</span>
                <h2 class="font-display text-2xl sm:text-3xl font-black text-slate-900">Paling Populer & Laris</h2>
            </div>
            <a href="#katalog" class="text-xs font-extrabold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                <span>Lihat Katalog Lengkap</span>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- Featured Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $fp)
                <div class="glass-panel rounded-3xl p-4 border border-slate-200 hover:border-blue-500/50 product-card bg-white flex flex-col justify-between">
                    <div class="relative group">
                        <img src="{{ $fp->image }}" alt="{{ $fp->name }}" class="w-full h-64 object-cover rounded-2xl bg-slate-100 border border-slate-100">
                        @if($fp->badge)
                            <span class="absolute top-3 left-3 bg-blue-600 text-white font-black text-[10px] uppercase px-3 py-1 rounded-xl tracking-wider shadow-md">
                                {{ $fp->badge }}
                            </span>
                        @endif
                        <button @click="openQuickView({{ $fp->id }})" class="absolute bottom-3 right-3 p-2.5 rounded-xl bg-white/90 hover:bg-blue-600 hover:text-white text-slate-800 backdrop-blur-sm transition-colors opacity-0 group-hover:opacity-100 shadow-md">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <div class="mt-4 space-y-2 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-extrabold text-blue-600 uppercase tracking-wider">{{ $fp->category ? $fp->category->name : 'Apparel' }}</span>
                            <h3 class="font-black text-base text-slate-900 line-clamp-1 hover:text-blue-600 transition-colors">
                                <a href="javascript:void(0)" @click="openQuickView({{ $fp->id }})">{{ $fp->name }}</a>
                            </h3>
                            <div class="flex items-center gap-1.5 mt-1">
                                <div class="flex text-amber-400">
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-700">{{ $fp->rating }}</span>
                                <span class="text-[10px] text-slate-400">({{ $fp->review_count }})</span>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="font-black text-lg text-blue-600">Rp {{ number_format($fp->effective_price, 0, ',', '.') }}</span>
                                @if($fp->discount_price)
                                    <span class="block text-[11px] text-slate-400 line-through font-semibold">Rp {{ number_format($fp->price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            <button @click="addToCart({{ $fp->id }}, 1)" class="p-2.5 rounded-xl bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200 transition-all shadow-sm">
                                <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Main Storefront Catalog & Filter Section -->
<section id="katalog" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header & Live Filter Bar -->
        <div class="space-y-6 mb-10">
            <div>
                <span class="text-xs font-black text-blue-600 uppercase tracking-widest">KATALOG APPAREL GAUL</span>
                <h2 class="font-display text-3xl font-black text-slate-900">Temukan Style Kamu</h2>
            </div>

            <!-- Filter Controls Container -->
            <form method="GET" action="{{ route('home') }}#katalog" class="glass-panel p-5 rounded-3xl border border-slate-200 bg-white space-y-4 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    
                    <!-- Search Input -->
                    <div class="md:col-span-5 relative">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari hoodie, kaos washed, warna, style..." class="w-full bg-slate-50 text-sm text-slate-900 pl-11 pr-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold placeholder-slate-400">
                    </div>

                    <!-- Size Filter -->
                    <div class="md:col-span-3">
                        <select name="size" onchange="this.form.submit()" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                            <option value="all" {{ request('size') == 'all' ? 'selected' : '' }}>Semua Size (S - XL)</option>
                            <option value="S" {{ request('size') == 'S' ? 'selected' : '' }}>Size S (Small)</option>
                            <option value="M" {{ request('size') == 'M' ? 'selected' : '' }}>Size M (Medium)</option>
                            <option value="L" {{ request('size') == 'L' ? 'selected' : '' }}>Size L (Large)</option>
                            <option value="XL" {{ request('size') == 'XL' ? 'selected' : '' }}>Size XL (Extra Large)</option>
                        </select>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="md:col-span-3">
                        <select name="sort" onchange="this.form.submit()" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Urutan: Paling Baru</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Termahal</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                        </select>
                    </div>

                    <!-- Submit / Reset Button -->
                    <div class="md:col-span-1 flex gap-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-2xl flex items-center justify-center transition-colors shadow-md shadow-blue-600/30">
                            <i data-lucide="filter" class="w-4 h-4"></i>
                        </button>
                    </div>

                </div>

                <!-- Category Pills Nav -->
                <div class="flex items-center gap-2 overflow-x-auto pt-2 pb-1 custom-scrollbar">
                    <a href="{{ route('home') }}#katalog" class="px-5 py-2 rounded-xl text-xs font-black whitespace-nowrap transition-all {{ !request('category') || request('category') == 'all' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua Apparel ({{ $products->count() }})
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('home', ['category' => $cat->slug]) }}#katalog" class="px-5 py-2 rounded-xl text-xs font-black whitespace-nowrap transition-all {{ request('category') == $cat->slug ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $cat->name }} ({{ $cat->products_count }})
                        </a>
                    @endforeach
                </div>
            </form>
        </div>

        <!-- Products Grid Showcase -->
        @if($products->isEmpty())
            <div class="glass-panel rounded-3xl p-12 text-center max-w-md mx-auto space-y-3 bg-white border border-slate-200 shadow-sm">
                <i data-lucide="package-search" class="w-12 h-12 text-slate-400 mx-auto"></i>
                <h3 class="font-black text-slate-900 text-lg">Produk Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 font-medium">Coba ganti kata kunci pencarian atau filter produk kamu.</p>
                <a href="{{ route('home') }}" class="inline-block mt-2 text-xs font-black text-blue-600 hover:underline">Reset Filter</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $prod)
                    <div class="glass-panel rounded-3xl p-4 border border-slate-200 hover:border-blue-500/50 product-card bg-white flex flex-col justify-between">
                        <div class="relative group overflow-hidden rounded-2xl bg-slate-100 border border-slate-100">
                            <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-full h-72 object-cover rounded-2xl group-hover:scale-105 transition-transform duration-500">
                            
                            @if($prod->badge)
                                <span class="absolute top-3 left-3 bg-blue-600 text-white font-black text-[10px] uppercase px-3 py-1 rounded-xl tracking-wider shadow-md">
                                    {{ $prod->badge }}
                                </span>
                            @endif

                            <div class="absolute inset-0 bg-slate-900/30 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                <button @click="openQuickView({{ $prod->id }})" class="p-3 rounded-2xl bg-white text-slate-900 hover:bg-blue-600 hover:text-white transition-colors shadow-lg">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </button>
                                <button @click="addToCart({{ $prod->id }}, 1)" class="p-3 rounded-2xl bg-blue-600 text-white hover:bg-blue-700 transition-colors shadow-lg">
                                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 space-y-2 flex-grow flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between text-[11px]">
                                    <span class="font-extrabold text-blue-600 uppercase tracking-wider">{{ $prod->category ? $prod->category->name : 'Apparel' }}</span>
                                    <span class="text-slate-400 font-semibold">Stok: {{ $prod->stock }}</span>
                                </div>
                                <h3 class="font-black text-base text-slate-900 mt-1 line-clamp-1 hover:text-blue-600 transition-colors">
                                    <a href="javascript:void(0)" @click="openQuickView({{ $prod->id }})">{{ $prod->name }}</a>
                                </h3>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <div class="flex text-amber-400">
                                        <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">{{ $prod->rating }}</span>
                                    <span class="text-[10px] text-slate-400">({{ $prod->review_count }} ulasan)</span>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="font-black text-lg text-blue-600">Rp {{ number_format($prod->effective_price, 0, ',', '.') }}</span>
                                    @if($prod->discount_price)
                                        <span class="block text-[11px] text-slate-400 line-through font-semibold">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <button @click="addToCart({{ $prod->id }}, 1)" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs shadow-md shadow-blue-600/30 transition-all">
                                    + Beli
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

<!-- Customer Reviews Section -->
<section class="py-16 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-black text-blue-600 uppercase tracking-widest">TESTIMONI ANAK GAUL</span>
            <h2 class="font-display text-3xl font-black text-slate-900 mt-1">Review Jujur Pelanggan</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-panel rounded-3xl p-6 border border-slate-200 space-y-4 bg-slate-50/50 shadow-sm">
                <div class="flex text-amber-400 gap-1">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    "Bahan Hoodie Oversized Heavy Metal tebal banget 330gsm! Potongan bahunya jatuh banget di badan, ga bikin gerah pas nongkrong malam. Keren abis!"
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 font-black flex items-center justify-center text-xs">AD</div>
                    <div>
                        <h5 class="text-xs font-black text-slate-900">Aditya Pratama</h5>
                        <p class="text-[10px] text-slate-400 font-semibold">Jakarta Selatan</p>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-3xl p-6 border border-slate-200 space-y-4 bg-slate-50/50 shadow-sm">
                <div class="flex text-amber-400 gap-1">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    "Acid Washed Vintage Tee persis kayak foto katalog. Warna biru & putih websitenya juga fresh banget gaul! Pengiriman QRIS kilat."
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <div class="w-9 h-9 rounded-xl bg-cyan-100 text-cyan-700 font-black flex items-center justify-center text-xs">RN</div>
                    <div>
                        <h5 class="text-xs font-black text-slate-900">Rian Nurbasari</h5>
                        <p class="text-[10px] text-slate-400 font-semibold">Bandung</p>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-3xl p-6 border border-slate-200 space-y-4 bg-slate-50/50 shadow-sm">
                <div class="flex text-amber-400 gap-1">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    "Celana Cargo Techwear nya keren parah! Saku banyak dan bahannya stretch, nyaman dipakai naik motor atau outfit kampus."
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 font-black flex items-center justify-center text-xs">DL</div>
                    <div>
                        <h5 class="text-xs font-black text-slate-900">Dian Laksamana</h5>
                        <p class="text-[10px] text-slate-400 font-semibold">Surabaya</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
