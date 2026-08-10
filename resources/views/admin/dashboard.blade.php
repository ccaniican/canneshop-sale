@extends('layouts.app')

@section('title', 'Admin Panel - Dashboard CanneShop Apparel')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen" x-data="{ activeTab: '{{ session('addUserError') ? 'users' : 'products' }}', addProductModal: false, editProductModal: false, editingProduct: null, addUserModal: {{ session('addUserError') ? 'true' : 'false' }}, editUserModal: false, editingUser: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Dashboard Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <span class="text-xs font-black text-blue-600 uppercase tracking-widest">CONTROL PANEL ADMIN</span>
                <h1 class="font-display text-3xl font-black text-slate-900">Kelola Toko Apparel & Pengguna</h1>
            </div>

            <div class="flex flex-wrap gap-3">
                <button @click="activeTab = 'users'; addUserModal = true" class="bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-300 font-bold px-4 py-3 rounded-2xl shadow-sm flex items-center gap-2 text-xs transition-all">
                    <i data-lucide="user-plus" class="w-4 h-4 text-blue-600"></i>
                    <span>+ Tambah User / Admin</span>
                </button>
                <button @click="activeTab = 'products'; addProductModal = true" class="bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-black px-5 py-3 rounded-2xl shadow-lg shadow-blue-600/30 flex items-center gap-2 text-xs transition-all">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>+ Tambah Produk Apparel</span>
                </button>
            </div>
        </div>

        <!-- 4 Key Analytics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-2 shadow-sm">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-black uppercase tracking-wider">Total Pendapatan</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <i data-lucide="dollar-sign" class="w-5 h-5"></i>
                    </div>
                </div>
                <h3 class="font-display text-2xl font-black text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-emerald-600 flex items-center gap-1 font-extrabold">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> Transaksi Terverifikasi Lunas
                </p>
            </div>

            <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-2 shadow-sm">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-black uppercase tracking-wider">Total Pesanan</span>
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    </div>
                </div>
                <h3 class="font-display text-2xl font-black text-slate-900">{{ $totalOrders }} Pesanan</h3>
                <p class="text-[10px] text-slate-500 font-bold">Masuk dari Storefront</p>
            </div>

            <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-2 shadow-sm">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-black uppercase tracking-wider">Total Produk</span>
                    <div class="w-9 h-9 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center">
                        <i data-lucide="layers" class="w-5 h-5"></i>
                    </div>
                </div>
                <h3 class="font-display text-2xl font-black text-slate-900">{{ $totalProducts }} Apparel</h3>
                <p class="text-[10px] text-slate-500 font-bold">Dalam {{ $categories->count() }} Kategori</p>
            </div>

            <div class="glass-panel p-6 rounded-3xl border border-slate-200 bg-white space-y-2 shadow-sm">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-black uppercase tracking-wider">Pengguna Terdaftar</span>
                    <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                </div>
                <h3 class="font-display text-2xl font-black text-purple-700">{{ $allUsers->count() }} User</h3>
                <p class="text-[10px] text-slate-500 font-bold">Admin & Pelanggan</p>
            </div>

        </div>

        <!-- Navigation Tabs for Admin Panel -->
        <div class="flex border-b border-slate-200 mb-6 gap-6 overflow-x-auto">
            <button @click="activeTab = 'products'" 
                    :class="activeTab === 'products' ? 'border-blue-600 text-blue-600 font-black' : 'border-transparent text-slate-500 hover:text-slate-900 font-bold'" 
                    class="py-3.5 px-1 border-b-2 text-sm flex items-center gap-2 transition-all whitespace-nowrap">
                <i data-lucide="package" class="w-4 h-4"></i>
                <span>Manajemen Produk ({{ $products->count() }})</span>
            </button>

            <button @click="activeTab = 'orders'" 
                    :class="activeTab === 'orders' ? 'border-blue-600 text-blue-600 font-black' : 'border-transparent text-slate-500 hover:text-slate-900 font-bold'" 
                    class="py-3.5 px-1 border-b-2 text-sm flex items-center gap-2 transition-all whitespace-nowrap">
                <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                <span>Kelola Pesanan ({{ $recentOrders->count() }})</span>
            </button>

            <button @click="activeTab = 'users'" 
                    :class="activeTab === 'users' ? 'border-blue-600 text-blue-600 font-black' : 'border-transparent text-slate-500 hover:text-slate-900 font-bold'" 
                    class="py-3.5 px-1 border-b-2 text-sm flex items-center gap-2 transition-all whitespace-nowrap">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>Manajemen User ({{ $allUsers->count() }})</span>
            </button>
        </div>

        <!-- TAB 1: Products Management Table -->
        <div x-show="activeTab === 'products'" class="space-y-6">
            <div class="glass-panel rounded-3xl border border-slate-200 bg-white overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100/80 border-b border-slate-200 text-slate-500 uppercase font-black tracking-wider">
                                <th class="p-4">Produk Apparel</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Harga Normal</th>
                                <th class="p-4">Harga Diskon</th>
                                <th class="p-4 text-center">Stok</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold">
                            @foreach($products as $p)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $p->image }}" alt="{{ $p->name }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100 border border-slate-200">
                                            <div>
                                                <h4 class="font-black text-slate-900 text-sm">{{ $p->name }}</h4>
                                                <div class="text-[11px] text-slate-400 flex items-center gap-2 font-medium">
                                                    <span>Warna: <strong class="text-slate-700 font-bold">{{ $p->color }}</strong></span>
                                                    <span>•</span>
                                                    <span>Rating: {{ $p->rating }} ★</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-black border border-blue-200 text-[10px]">
                                            {{ $p->category ? $p->category->name : '-' }}
                                        </span>
                                    </td>
                                    <td class="p-4 font-bold text-slate-700">
                                        Rp {{ number_format($p->price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 font-black text-blue-600">
                                        {{ $p->discount_price ? 'Rp ' . number_format($p->discount_price, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="px-3 py-1 rounded-full font-black text-[10px] {{ $p->stock <= 10 ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                            {{ $p->stock }} Pcs
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="editingProduct = {{ json_encode($p) }}; editProductModal = true" class="p-2 rounded-xl bg-slate-100 text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition-colors border border-slate-200">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </button>
                                            
                                            <form action="{{ route('admin.product.delete', $p->id) }}" method="POST" onsubmit="return confirm('Yakin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200 transition-colors">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 2: Orders Management Table -->
        <div x-show="activeTab === 'orders'" class="space-y-6" style="display: none;">
            <div class="glass-panel rounded-3xl border border-slate-200 bg-white overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100/80 border-b border-slate-200 text-slate-500 uppercase font-black tracking-wider">
                                <th class="p-4">No. Invoice & Pembeli</th>
                                <th class="p-4">Alamat Pengiriman</th>
                                <th class="p-4">Rincian Barang</th>
                                <th class="p-4">Total Bayar</th>
                                <th class="p-4 text-center">Status Pesanan</th>
                                <th class="p-4 text-center">Update Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold">
                            @foreach($recentOrders as $order)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="p-4">
                                        <div class="space-y-1">
                                            <strong class="text-blue-600 font-mono text-sm block font-black">{{ $order->order_number }}</strong>
                                            <p class="font-black text-slate-900">{{ $order->customer_name }}</p>
                                            <p class="text-slate-400 text-[10px] font-medium">{{ $order->customer_phone }} | {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <p class="text-slate-700 max-w-xs line-clamp-2">{{ $order->shipping_address }}, {{ $order->city }}</p>
                                        <span class="text-[10px] text-slate-400 font-semibold">Kurir: {{ $order->courier }}</span>
                                    </td>
                                    <td class="p-4">
                                        <ul class="space-y-1">
                                            @foreach($order->items as $it)
                                                <li class="text-slate-700">
                                                    • {{ $it->product_name }} (<span class="text-blue-600 font-black">{{ $it->size }}</span>) x {{ $it->quantity }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="p-4">
                                        <strong class="text-slate-900 text-sm font-black">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</strong>
                                        <span class="block text-[10px] text-emerald-600 font-bold mt-0.5">{{ $order->payment_method }} (LUNAS)</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border 
                                            @if($order->order_status === 'Selesai') bg-emerald-100 text-emerald-800 border-emerald-300
                                            @elseif($order->order_status === 'Dikirim') bg-blue-100 text-blue-800 border-blue-300
                                            @elseif($order->order_status === 'Diproses') bg-cyan-100 text-cyan-800 border-cyan-300
                                            @else bg-slate-100 text-slate-600 border-slate-200 @endif">
                                            {{ $order->order_status }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                                            @csrf
                                            <select name="order_status" onchange="this.form.submit()" class="bg-slate-50 text-slate-900 border border-slate-300 text-xs px-3 py-1.5 rounded-xl font-bold focus:outline-none focus:border-blue-600">
                                                <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Diproses" {{ $order->order_status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="Dikirim" {{ $order->order_status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                                <option value="Selesai" {{ $order->order_status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="Dibatalkan" {{ $order->order_status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 3: User Management Table (CRUD User & Admin) -->
        <div x-show="activeTab === 'users'" class="space-y-6" style="display: none;">
            <div class="glass-panel rounded-3xl border border-slate-200 bg-white overflow-hidden shadow-sm">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-black text-base text-slate-900">Daftar Pengguna Sistem</h3>
                        <p class="text-xs text-slate-500 font-semibold">Kelola hak akses Admin dan akun Pelanggan toko apparel</p>
                    </div>
                    <button @click="addUserModal = true" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-black px-4 py-2.5 rounded-xl shadow-md shadow-blue-600/30 transition-all flex items-center gap-1.5">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>+ Tambah Akun</span>
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100/80 border-b border-slate-200 text-slate-500 uppercase font-black tracking-wider">
                                <th class="p-4">ID</th>
                                <th class="p-4">Nama Pengguna</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">No. HP / WA</th>
                                <th class="p-4 text-center">Role / Akses</th>
                                <th class="p-4">Terdaftar</th>
                                <th class="p-4 text-center">Aksi CRUD</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold">
                            @foreach($allUsers as $u)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="p-4 font-mono font-bold text-slate-400">#{{ $u->id }}</td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 font-black text-slate-700 flex items-center justify-center text-xs">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <strong class="text-slate-900 block font-black">{{ $u->name }}</strong>
                                                @if(Auth::id() === $u->id)
                                                    <span class="text-[9px] text-blue-600 font-black uppercase">(Akun Anda)</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 font-bold text-slate-700">{{ $u->email }}</td>
                                    <td class="p-4 text-slate-500">{{ $u->phone ?: '-' }}</td>
                                    <td class="p-4 text-center">
                                        <span class="px-3 py-1 rounded-full font-black text-[10px] uppercase border {{ $u->role === 'admin' ? 'bg-blue-100 text-blue-800 border-blue-300' : 'bg-cyan-100 text-cyan-800 border-cyan-300' }}">
                                            {{ $u->role }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-slate-400 font-medium">{{ $u->created_at->format('d M Y') }}</td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="editingUser = {{ json_encode($u) }}; editUserModal = true" class="p-2 rounded-xl bg-slate-100 text-slate-700 hover:text-blue-600 hover:bg-blue-50 transition-colors border border-slate-200">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </button>
                                            
                                            @if(Auth::id() !== $u->id)
                                                <form action="{{ route('admin.user.delete', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun user {{ $u->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200 transition-colors">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-[10px] text-slate-400 italic font-semibold">Aktif</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal 1: Add New Product -->
    <div x-show="addProductModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" style="display: none;">
        <div @click="addProductModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>

        <div class="relative glass-panel bg-white border border-slate-200 rounded-3xl max-w-2xl w-full p-6 text-slate-900 overflow-hidden shadow-2xl z-10 space-y-4" @click.stop>
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-display font-black text-lg text-slate-900">Tambah Produk Apparel Baru</h3>
                <button @click="addProductModal = false" class="text-slate-400 hover:text-slate-900"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>

            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-semibold">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Produk Apparel *</label>
                        <input type="text" name="name" required placeholder="Contoh: Canne Oversized Knit Sweater" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori *</label>
                        <select name="category_id" required class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Harga Normal (Rp) *</label>
                        <input type="number" name="price" required placeholder="299000" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Harga Diskon (Rp Opsional)</label>
                        <input type="number" name="discount_price" placeholder="249000" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Stok *</label>
                        <input type="number" name="stock" required value="20" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Warna *</label>
                        <input type="text" name="color" required placeholder="Electric Blue / White" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">Pilihan Size Tersedia *</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5"><input type="checkbox" name="sizes[]" value="S" checked class="accent-blue-600"> Size S</label>
                            <label class="flex items-center gap-1.5"><input type="checkbox" name="sizes[]" value="M" checked class="accent-blue-600"> Size M</label>
                            <label class="flex items-center gap-1.5"><input type="checkbox" name="sizes[]" value="L" checked class="accent-blue-600"> Size L</label>
                            <label class="flex items-center gap-1.5"><input type="checkbox" name="sizes[]" value="XL" checked class="accent-blue-600"> Size XL</label>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">URL Gambar Produk</label>
                        <input type="text" name="image_url" placeholder="/images/products/oversized_hoodie.jpg" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Produk *</label>
                        <textarea name="description" rows="3" required placeholder="Jelaskan spesifikasi bahan & style apparel..." class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900"></textarea>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Badge Promo</label>
                        <select name="badge" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                            <option value="">Tidak Ada</option>
                            <option value="BESTSELLER">BESTSELLER</option>
                            <option value="NEW">NEW</option>
                            <option value="HOT SALE">HOT SALE</option>
                            <option value="LIMITED">LIMITED</option>
                        </select>
                    </div>

                    <div class="flex items-center pt-5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" class="accent-blue-600">
                            <span class="font-black text-blue-600">Tampilkan di Highlight Bestseller</span>
                        </label>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="addProductModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200 text-xs">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-md shadow-blue-600/30">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Edit Existing Product -->
    <div x-show="editProductModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" style="display: none;">
        <div @click="editProductModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>

        <div class="relative glass-panel bg-white border border-slate-200 rounded-3xl max-w-2xl w-full p-6 text-slate-900 overflow-hidden shadow-2xl z-10 space-y-4" @click.stop x-data="{ currentFormUrl: '' }" x-init="$watch('editingProduct', val => { if(val) currentFormUrl = '{{ url('admin/product') }}/' + val.id + '/update'; })">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-display font-black text-lg text-slate-900">Edit Produk Apparel</h3>
                <button @click="editProductModal = false" class="text-slate-400 hover:text-slate-900"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>

            <template x-if="editingProduct">
                <form :action="currentFormUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-semibold">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Nama Produk *</label>
                            <input type="text" name="name" :value="editingProduct.name" required class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Kategori *</label>
                            <select name="category_id" required class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" :selected="editingProduct.category_id == {{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Harga Normal (Rp) *</label>
                            <input type="number" name="price" :value="editingProduct.price" required class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Harga Diskon (Rp)</label>
                            <input type="number" name="discount_price" :value="editingProduct.discount_price" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Stok *</label>
                            <input type="number" name="stock" :value="editingProduct.stock" required class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Warna *</label>
                            <input type="text" name="color" :value="editingProduct.color" required class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-bold text-slate-700 mb-1">Pilihan Size Tersedia *</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-1.5"><input type="checkbox" name="sizes[]" value="S" :checked="editingProduct.sizes && editingProduct.sizes.includes('S')" class="accent-blue-600"> Size S</label>
                                <label class="flex items-center gap-1.5"><input type="checkbox" name="sizes[]" value="M" :checked="editingProduct.sizes && editingProduct.sizes.includes('M')" class="accent-blue-600"> Size M</label>
                                <label class="flex items-center gap-1.5"><input type="checkbox" name="sizes[]" value="L" :checked="editingProduct.sizes && editingProduct.sizes.includes('L')" class="accent-blue-600"> Size L</label>
                                <label class="flex items-center gap-1.5"><input type="checkbox" name="sizes[]" value="XL" :checked="editingProduct.sizes && editingProduct.sizes.includes('XL')" class="accent-blue-600"> Size XL</label>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-bold text-slate-700 mb-1">URL / Path Gambar Produk</label>
                            <input type="text" name="image_url" :value="editingProduct.image" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-bold text-slate-700 mb-1">Deskripsi Produk *</label>
                            <textarea name="description" rows="3" required x-text="editingProduct.description" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900"></textarea>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Badge Promo</label>
                            <select name="badge" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                                <option value="">Tidak Ada</option>
                                <option value="BESTSELLER" :selected="editingProduct.badge === 'BESTSELLER'">BESTSELLER</option>
                                <option value="NEW" :selected="editingProduct.badge === 'NEW'">NEW</option>
                                <option value="HOT SALE" :selected="editingProduct.badge === 'HOT SALE'">HOT SALE</option>
                                <option value="LIMITED" :selected="editingProduct.badge === 'LIMITED'">LIMITED</option>
                            </select>
                        </div>

                        <div class="flex items-center pt-5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" :checked="editingProduct.is_featured" class="accent-blue-600">
                                <span class="font-black text-blue-600">Tampilkan di Highlight Bestseller</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="editProductModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 font-bold text-slate-700 hover:bg-slate-200 text-xs">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-md shadow-blue-600/30">Perbarui Produk</button>
                    </div>
                </form>
            </template>
        </div>
    </div>

    <!-- Modal 3: Add New User (CRUD User/Admin) -->
    <div x-show="addUserModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" style="display: none;">
        <div @click="addUserModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>

        <div class="relative glass-panel bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 text-slate-900 overflow-hidden shadow-2xl z-10 space-y-4" @click.stop>
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-display font-black text-lg text-slate-900">Tambah Akun User / Admin Baru</h3>
                <button @click="addUserModal = false" class="text-slate-400 hover:text-slate-900"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>

            @if($errors->userStore->any())
                <div class="bg-rose-50 border border-rose-300 text-rose-800 text-xs p-3 rounded-2xl font-semibold space-y-1">
                    @foreach($errors->userStore->all() as $err)
                        <p>• {{ $err }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-4 text-xs font-semibold">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: Farhan Ramadhan" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Email *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="farhan@canne.shop" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor Handphone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="081234567890" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Role / Hak Akses *</label>
                    <select name="role" required class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900 font-bold">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>USER / PELANGGAN</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>ADMINISTRATOR</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Password *</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="addUserModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 font-bold text-slate-700 hover:bg-slate-200">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black shadow-md shadow-blue-600/30">Simpan Akun Baru</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 4: Edit Existing User -->
    <div x-show="editUserModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" style="display: none;">
        <div @click="editUserModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>

        <div class="relative glass-panel bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 text-slate-900 overflow-hidden shadow-2xl z-10 space-y-4" @click.stop x-data="{ userFormUrl: '' }" x-init="$watch('editingUser', val => { if(val) userFormUrl = '{{ url('admin/user') }}/' + val.id + '/update'; })">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-display font-black text-lg text-slate-900">Edit Akun Pengguna</h3>
                <button @click="editUserModal = false" class="text-slate-400 hover:text-slate-900"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>

            <template x-if="editingUser">
                <form :action="userFormUrl" method="POST" class="space-y-4 text-xs font-semibold">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" :value="editingUser.name" required class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Email *</label>
                        <input type="email" name="email" :value="editingUser.email" required class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor Handphone</label>
                        <input type="text" name="phone" :value="editingUser.phone" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Role / Hak Akses *</label>
                        <select name="role" required class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900 font-bold">
                            <option value="user" :selected="editingUser.role === 'user'">USER / PELANGGAN</option>
                            <option value="admin" :selected="editingUser.role === 'admin'">ADMINISTRATOR</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Password Baru (Biarkan kosong jika tidak diubah)</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-900">
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="editUserModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 font-bold text-slate-700 hover:bg-slate-200">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black shadow-md shadow-blue-600/30">Perbarui Akun</button>
                    </div>
                </form>
            </template>
        </div>
    </div>

</div>
@endsection
