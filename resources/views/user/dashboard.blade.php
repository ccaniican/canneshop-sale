@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - CanneShop Apparel')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen" x-data="{ activeTab: 'orders' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Customer Banner Header -->
        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-slate-200 bg-white mb-8 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-500 text-white font-black text-2xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="font-display text-2xl font-black text-slate-900">Halo, {{ $user->name }}!</h1>
                        <span class="px-2.5 py-0.5 rounded-full bg-cyan-100 text-cyan-800 text-[10px] font-black uppercase border border-cyan-300">
                            {{ $user->role === 'admin' ? 'ADMINISTRATOR' : 'PELANGGAN VIP' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">{{ $user->email }} • {{ $user->phone ?: 'Belum ada No. HP' }}</p>
                </div>
            </div>

            <div class="flex gap-3 w-full md:w-auto">
                <a href="{{ route('home') }}" class="flex-1 md:flex-none text-center bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs px-5 py-3 rounded-2xl shadow-md shadow-blue-600/30 transition-all">
                    + Belanja Apparel Lagi
                </a>
            </div>
        </div>

        <!-- 3 Customer Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-2 shadow-sm">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-black uppercase tracking-wider">Total Belanjaan</span>
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    </div>
                </div>
                <h3 class="font-display text-2xl font-black text-slate-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-slate-500 font-bold">Total Pembayaran Lunas</p>
            </div>

            <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-2 shadow-sm">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-black uppercase tracking-wider">Total Transaksi</span>
                    <div class="w-9 h-9 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center">
                        <i data-lucide="receipt" class="w-5 h-5"></i>
                    </div>
                </div>
                <h3 class="font-display text-2xl font-black text-slate-900">{{ $totalOrdersCount }} Pesanan</h3>
                <p class="text-[10px] text-slate-500 font-bold">Telah Dibuat di CanneShop</p>
            </div>

            <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-2 shadow-sm">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-black uppercase tracking-wider">Sedang Dikirim</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <i data-lucide="truck" class="w-5 h-5"></i>
                    </div>
                </div>
                <h3 class="font-display text-2xl font-black text-amber-600">{{ $activeOrdersCount }} Pesanan</h3>
                <p class="text-[10px] text-slate-500 font-bold">Dalam Proses & Pengiriman</p>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex border-b border-slate-200 mb-6 gap-6 overflow-x-auto">
            <button @click="activeTab = 'orders'" 
                    :class="activeTab === 'orders' ? 'border-blue-600 text-blue-600 font-black' : 'border-transparent text-slate-500 hover:text-slate-900 font-bold'" 
                    class="py-3.5 px-1 border-b-2 text-sm flex items-center gap-2 transition-all whitespace-nowrap">
                <i data-lucide="package" class="w-4 h-4"></i>
                <span>Riwayat Pesanan Saya ({{ $myOrders->count() }})</span>
            </button>

            <button @click="activeTab = 'profile'" 
                    :class="activeTab === 'profile' ? 'border-blue-600 text-blue-600 font-black' : 'border-transparent text-slate-500 hover:text-slate-900 font-bold'" 
                    class="py-3.5 px-1 border-b-2 text-sm flex items-center gap-2 transition-all whitespace-nowrap">
                <i data-lucide="user" class="w-4 h-4"></i>
                <span>Pengaturan Profil</span>
            </button>

            <button @click="activeTab = 'security'" 
                    :class="activeTab === 'security' ? 'border-blue-600 text-blue-600 font-black' : 'border-transparent text-slate-500 hover:text-slate-900 font-bold'" 
                    class="py-3.5 px-1 border-b-2 text-sm flex items-center gap-2 transition-all whitespace-nowrap">
                <i data-lucide="lock" class="w-4 h-4"></i>
                <span>Ubah Password</span>
            </button>
        </div>

        <!-- TAB 1: My Orders History -->
        <div x-show="activeTab === 'orders'" class="space-y-6">
            @if($myOrders->isEmpty())
                <div class="glass-panel rounded-3xl p-12 text-center max-w-md mx-auto space-y-3 bg-white border border-slate-200 shadow-sm">
                    <i data-lucide="shopping-bag" class="w-12 h-12 text-slate-400 mx-auto"></i>
                    <h3 class="font-black text-slate-900 text-lg">Belum Ada Riwayat Pesanan</h3>
                    <p class="text-xs text-slate-500 font-semibold">Jelajahi produk apparel hits CanneShop dan pesan sekarang!</p>
                    <a href="{{ route('home') }}" class="inline-block mt-2 text-xs font-black text-blue-600 hover:underline">+ Belanja Apparel</a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($myOrders as $order)
                        <div class="glass-panel rounded-3xl p-6 border border-slate-200 bg-white space-y-4 shadow-sm hover:border-blue-300 transition-all">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                                <div class="flex items-center gap-3">
                                    <span class="font-mono font-black text-blue-600 text-sm">{{ $order->order_number }}</span>
                                    <span class="text-xs text-slate-400 font-semibold">• {{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border 
                                        @if($order->order_status === 'Selesai') bg-emerald-100 text-emerald-800 border-emerald-300
                                        @elseif($order->order_status === 'Dikirim') bg-blue-100 text-blue-800 border-blue-300
                                        @elseif($order->order_status === 'Diproses') bg-cyan-100 text-cyan-800 border-cyan-300
                                        @else bg-slate-100 text-slate-600 border-slate-200 @endif">
                                        Status: {{ $order->order_status }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider">Item Dipesan:</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                    @foreach($order->items as $it)
                                        <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50 border border-slate-200">
                                            <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-black text-blue-600 text-xs">
                                                {{ $it->size }}
                                            </div>
                                            <div>
                                                <h5 class="font-bold text-slate-900 line-clamp-1">{{ $it->product_name }}</h5>
                                                <p class="text-slate-500 text-[11px]">Qty: {{ $it->quantity }} Pcs • Rp {{ number_format($it->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                                <div>
                                    <span class="text-slate-500 font-semibold">Total Tagihan: </span>
                                    <strong class="font-black text-blue-600 text-base">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</strong>
                                    <span class="text-[11px] text-slate-400 font-bold ml-2">({{ $order->payment_method }})</span>
                                </div>
                                <a href="{{ route('checkout.success', $order->order_number) }}" class="inline-flex items-center justify-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-4 py-2 rounded-xl border border-slate-200 transition-colors">
                                    <i data-lucide="file-text" class="w-4 h-4 text-blue-600"></i>
                                    <span>Lihat Invoice Struk</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- TAB 2: Edit Profile -->
        <div x-show="activeTab === 'profile'" class="max-w-2xl space-y-6" style="display: none;">
            <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white shadow-sm space-y-4">
                <h3 class="font-black text-lg text-slate-900 border-b border-slate-100 pb-3">Perbarui Profil Pelanggan</h3>

                <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4 text-xs font-semibold">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" required value="{{ old('name', $user->name) }}" class="w-full bg-slate-50 p-3.5 rounded-2xl border border-slate-200 text-slate-900 focus:outline-none focus:border-blue-600 font-semibold">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Alamat Email *</label>
                        <input type="email" name="email" required value="{{ old('email', $user->email) }}" class="w-full bg-slate-50 p-3.5 rounded-2xl border border-slate-200 text-slate-900 focus:outline-none focus:border-blue-600 font-semibold">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor Handphone / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="081234567890" class="w-full bg-slate-50 p-3.5 rounded-2xl border border-slate-200 text-slate-900 focus:outline-none focus:border-blue-600 font-semibold">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black px-6 py-3 rounded-2xl shadow-md shadow-blue-600/30 transition-all">
                            Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- TAB 3: Change Password -->
        <div x-show="activeTab === 'security'" class="max-w-2xl space-y-6" style="display: none;">
            <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white shadow-sm space-y-4">
                <h3 class="font-black text-lg text-slate-900 border-b border-slate-100 pb-3">Ubah Password Akun</h3>

                @if($errors->has('current_password'))
                    <div class="bg-rose-50 border border-rose-300 text-rose-800 text-xs p-3 rounded-2xl font-semibold">
                        {{ $errors->first('current_password') }}
                    </div>
                @endif

                <form action="{{ route('user.password.update') }}" method="POST" class="space-y-4 text-xs font-semibold">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Password Saat Ini *</label>
                        <input type="password" name="current_password" required placeholder="••••••••" class="w-full bg-slate-50 p-3.5 rounded-2xl border border-slate-200 text-slate-900 focus:outline-none focus:border-blue-600 font-semibold">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Password Baru *</label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full bg-slate-50 p-3.5 rounded-2xl border border-slate-200 text-slate-900 focus:outline-none focus:border-blue-600 font-semibold">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Konfirmasi Password Baru *</label>
                        <input type="password" name="password_confirmation" required placeholder="Ketik ulang password baru" class="w-full bg-slate-50 p-3.5 rounded-2xl border border-slate-200 text-slate-900 focus:outline-none focus:border-blue-600 font-semibold">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black px-6 py-3 rounded-2xl shadow-md shadow-blue-600/30 transition-all">
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
