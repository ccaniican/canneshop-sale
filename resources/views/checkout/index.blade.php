@extends('layouts.app')

@section('title', 'Checkout Pembelian - CanneShop Apparel')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Header -->
        <div class="mb-8 space-y-2">
            <div class="flex items-center gap-2 text-xs text-slate-500 font-semibold">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                <span>/</span>
                <span class="text-slate-800">Checkout</span>
            </div>
            <h1 class="font-display text-3xl font-black text-slate-900">Checkout & Data Pengiriman</h1>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Main Section: Customer Form, Shipping & Payment -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- 1. Customer Info Panel -->
                    <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-4 shadow-sm">
                        <div class="flex items-center gap-2 text-blue-600 font-black border-b border-slate-100 pb-3">
                            <i data-lucide="user" class="w-5 h-5"></i>
                            <h3 class="text-slate-900 text-base">Informasi Pembeli</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                                <input type="text" name="customer_name" required value="{{ old('customer_name', 'Budi Santoso') }}" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email *</label>
                                <input type="email" name="customer_email" required value="{{ old('customer_email', 'budi.santoso@example.com') }}" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp / HP *</label>
                                <input type="text" name="customer_phone" required value="{{ old('customer_phone', '081234567890') }}" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                            </div>
                        </div>
                    </div>

                    <!-- 2. Shipping Address Panel -->
                    <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-4 shadow-sm">
                        <div class="flex items-center gap-2 text-blue-600 font-black border-b border-slate-100 pb-3">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                            <h3 class="text-slate-900 text-base">Alamat Pengiriman</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap (Jalan, No. Rumah, RT/RW) *</label>
                                <textarea name="shipping_address" rows="3" required class="w-full bg-slate-50 text-sm text-slate-900 p-4 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">Jl. Sudirman No. 45, RT 02 / RW 05, Kebayoran Baru</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Kota / Kabupaten *</label>
                                    <input type="text" name="city" required value="{{ old('city', 'Jakarta Selatan') }}" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Kode Pos *</label>
                                    <input type="text" name="postal_code" required value="{{ old('postal_code', '12190') }}" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Pilih Kurir Pengiriman *</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <label class="border border-slate-200 bg-slate-50 p-3.5 rounded-2xl flex flex-col justify-between cursor-pointer hover:border-blue-600 transition-all">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-black text-slate-900">JNE Regular</span>
                                            <input type="radio" name="courier" value="JNE Regular" checked class="accent-blue-600">
                                        </div>
                                        <span class="text-[11px] text-slate-500 font-semibold mt-2">Rp 15.000 (2-3 Hari)</span>
                                    </label>

                                    <label class="border border-slate-200 bg-slate-50 p-3.5 rounded-2xl flex flex-col justify-between cursor-pointer hover:border-blue-600 transition-all">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-black text-slate-900">JNE Express</span>
                                            <input type="radio" name="courier" value="JNE Express (Next Day)" class="accent-blue-600">
                                        </div>
                                        <span class="text-[11px] text-slate-500 font-semibold mt-2">Rp 25.000 (Besok Sampai)</span>
                                    </label>

                                    <label class="border border-slate-200 bg-slate-50 p-3.5 rounded-2xl flex flex-col justify-between cursor-pointer hover:border-blue-600 transition-all">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-black text-slate-900">SiCepat Cargo</span>
                                            <input type="radio" name="courier" value="SiCepat Cargo" class="accent-blue-600">
                                        </div>
                                        <span class="text-[11px] text-slate-500 font-semibold mt-2">Rp 18.000 (1-2 Hari)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Payment Method Panel -->
                    <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-4 shadow-sm">
                        <div class="flex items-center gap-2 text-blue-600 font-black border-b border-slate-100 pb-3">
                            <i data-lucide="credit-card" class="w-5 h-5"></i>
                            <h3 class="text-slate-900 text-base">Metode Pembayaran</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="border-2 border-blue-600 bg-blue-50/50 p-4 rounded-2xl flex items-center justify-between cursor-pointer transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md">
                                        <i data-lucide="qr-code" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-black text-slate-900">QRIS Instan</span>
                                        <span class="text-[10px] text-slate-500 font-semibold">Scan via BCA/Gopay/OVO</span>
                                    </div>
                                </div>
                                <input type="radio" name="payment_method" value="QRIS Instan" checked class="accent-blue-600">
                            </label>

                            <label class="border border-slate-200 bg-slate-50 p-4 rounded-2xl flex items-center justify-between cursor-pointer hover:border-blue-600 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                                        <i data-lucide="building-2" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-black text-slate-900">Transfer Bank VA</span>
                                        <span class="text-[10px] text-slate-500 font-semibold">BCA / Mandiri / BNI</span>
                                    </div>
                                </div>
                                <input type="radio" name="payment_method" value="Transfer Bank Virtual" class="accent-blue-600">
                            </label>

                            <label class="border border-slate-200 bg-slate-50 p-4 rounded-2xl flex items-center justify-between cursor-pointer hover:border-blue-600 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center">
                                        <i data-lucide="wallet" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-black text-slate-900">E-Wallet</span>
                                        <span class="text-[10px] text-slate-500 font-semibold">GoPay / ShopeePay</span>
                                    </div>
                                </div>
                                <input type="radio" name="payment_method" value="E-Wallet" class="accent-blue-600">
                            </label>

                            <label class="border border-slate-200 bg-slate-50 p-4 rounded-2xl flex items-center justify-between cursor-pointer hover:border-blue-600 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                                        <i data-lucide="truck" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-black text-slate-900">COD (Bayar di Tempat)</span>
                                        <span class="text-[10px] text-slate-500 font-semibold">Bayar Saat Barang Sampai</span>
                                    </div>
                                </div>
                                <input type="radio" name="payment_method" value="COD (Bayar di Tempat)" class="accent-blue-600">
                            </label>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                            <input type="text" name="notes" placeholder="Contoh: Titipkan di pos sekuriti jika rumah kosong" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                        </div>
                    </div>

                </div>

                <!-- Right Sidebar: Order Items Summary & Payment Button -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-4 sticky top-28 shadow-lg">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h3 class="font-display font-black text-slate-900 text-base">Ringkasan Pesanan</h3>
                            <span class="text-xs text-blue-600 font-black">{{ count($cart) }} Item</span>
                        </div>

                        <!-- Item list preview -->
                        <div class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar pr-1">
                            @foreach($cart as $item)
                                <div class="flex gap-3 items-center text-xs">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100 border border-slate-200">
                                    <div class="flex-grow">
                                        <h4 class="font-bold text-slate-900 line-clamp-1">{{ $item['name'] }}</h4>
                                        <p class="text-slate-500">Size: <strong class="text-blue-600 font-black">{{ $item['size'] }}</strong> x {{ $item['quantity'] }}</p>
                                    </div>
                                    <span class="font-bold text-slate-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Breakdown calculations -->
                        <div class="pt-4 border-t border-slate-100 space-y-2 text-xs text-slate-600 font-semibold">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Subtotal Produk:</span>
                                <span class="text-slate-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if($discount > 0)
                                <div class="flex justify-between text-emerald-600 font-bold">
                                    <span>Diskon Kupon ({{ $coupon['code'] }}):</span>
                                    <span>- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-slate-500">Ongkos Kirim:</span>
                                <span class="text-slate-900">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between font-black text-lg text-slate-900 pt-3 border-t border-slate-200">
                                <span>Total Pembayaran:</span>
                                <span class="text-blue-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 via-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-600/30 flex items-center justify-center gap-2 text-sm transition-all transform hover:-translate-y-0.5 mt-4">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                            <span>Konfirmasi & Buat Pesanan</span>
                        </button>

                        <div class="text-[11px] text-slate-400 text-center flex items-center justify-center gap-1 mt-2 font-semibold">
                            <i data-lucide="lock" class="w-3.5 h-3.5 text-blue-600"></i>
                            <span>Sistem Transaksi Terenkripsi SSL 256-bit Aman</span>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection
