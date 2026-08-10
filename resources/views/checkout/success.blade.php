@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Invoice ' . $order->order_number)

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Confirmation Container Card -->
        <div id="invoice-card" class="glass-panel rounded-3xl p-8 border border-slate-200 bg-white space-y-6 shadow-2xl relative overflow-hidden">
            
            <!-- Glow background -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Header Badge -->
            <div class="text-center space-y-3 pb-6 border-b border-slate-100">
                <div class="w-16 h-16 rounded-3xl bg-blue-50 text-blue-600 border border-blue-200 mx-auto flex items-center justify-center shadow-lg shadow-blue-500/10">
                    <i data-lucide="check-circle" class="w-9 h-9"></i>
                </div>
                <h1 class="font-display text-2xl sm:text-3xl font-black text-slate-900">Pembayaran & Pesanan Berhasil!</h1>
                <p class="text-xs text-slate-500 font-semibold">Terima kasih telah berbelanja di <strong class="text-blue-600">CanneShop Apparel</strong>. Pesanan kamu sedang diproses tim gudang.</p>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-800 font-mono text-xs font-bold">
                    <span>No. Invoice: <strong>{{ $order->order_number }}</strong></span>
                </div>
            </div>

            <!-- Meta Information Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs font-semibold">
                <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200">
                    <span class="text-slate-400 block mb-1">Tanggal Pesanan</span>
                    <strong class="text-slate-900">{{ $order->created_at->format('d M Y, H:i') }} WIB</strong>
                </div>
                <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200">
                    <span class="text-slate-400 block mb-1">Metode Bayar</span>
                    <strong class="text-blue-600 font-black">{{ $order->payment_method }}</strong>
                </div>
                <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200">
                    <span class="text-slate-400 block mb-1">Status Bayar</span>
                    <span class="inline-block px-2.5 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 font-black border border-emerald-300">LUNAS (PAID)</span>
                </div>
                <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200">
                    <span class="text-slate-400 block mb-1">Status Pengiriman</span>
                    <span class="inline-block px-2.5 py-0.5 rounded-lg bg-blue-100 text-blue-800 font-black border border-blue-300">{{ $order->order_status }}</span>
                </div>
            </div>

            <!-- Customer Shipping Info -->
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2 text-xs">
                <h4 class="font-black text-slate-900 text-sm flex items-center gap-1.5">
                    <i data-lucide="map-pin" class="w-4 h-4 text-blue-600"></i> Alamat Tujuan Pengiriman
                </h4>
                <p class="text-slate-800 font-bold">{{ $order->customer_name }} ({{ $order->customer_phone }})</p>
                <p class="text-slate-600 font-medium">{{ $order->shipping_address }}, {{ $order->city }} - {{ $order->postal_code }}</p>
                <p class="text-slate-600 font-medium">Kurir: <strong class="text-slate-900">{{ $order->courier }}</strong></p>
                @if($order->notes)
                    <p class="text-blue-600 italic pt-1 border-t border-slate-200 font-semibold">"{{ $order->notes }}"</p>
                @endif
            </div>

            <!-- Items Table -->
            <div class="space-y-3">
                <h4 class="font-black text-slate-900 text-sm">Rincian Barang Apparel</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase">
                                <th class="pb-2">Produk</th>
                                <th class="pb-2 text-center">Ukuran</th>
                                <th class="pb-2 text-center">Qty</th>
                                <th class="pb-2 text-right">Harga</th>
                                <th class="pb-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="py-3 text-slate-900 font-bold">{{ $item->product_name }}</td>
                                    <td class="py-3 text-center text-blue-600 font-black">{{ $item->size ?: '-' }}</td>
                                    <td class="py-3 text-center text-slate-700">{{ $item->quantity }}</td>
                                    <td class="py-3 text-right text-slate-500">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="py-3 text-right font-black text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total Price Summary -->
            <div class="pt-4 border-t border-slate-100 space-y-2 text-xs text-slate-600 font-semibold">
                <div class="flex justify-between">
                    <span class="text-slate-500">Subtotal Produk:</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-emerald-600 font-bold">
                        <span>Diskon Kupon Promo:</span>
                        <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-slate-500">Ongkos Kirim:</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-black text-lg text-slate-900 pt-3 border-t border-slate-200">
                    <span>Total Pembayaran:</span>
                    <span class="text-blue-600">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-4 items-center justify-between">
                <button onclick="window.print()" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-extrabold px-5 py-3 rounded-2xl border border-slate-200 text-xs flex items-center gap-2 transition-colors">
                    <i data-lucide="printer" class="w-4 h-4 text-blue-600"></i>
                    <span>Cetak Struk Invoice</span>
                </button>
                
                <div class="flex gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-black px-4 py-3 rounded-2xl transition-colors">
                        Panel Admin
                    </a>
                    <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs px-6 py-3 rounded-2xl shadow-lg shadow-blue-600/30 transition-all">
                        Lanjut Belanja Apparel
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
