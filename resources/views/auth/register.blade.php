@extends('layouts.app')

@section('title', 'Daftar Akun Baru - CanneShop Apparel')

@section('content')
<div class="py-16 bg-slate-50 min-h-[85vh] flex items-center justify-center">
    <div class="max-w-md w-full mx-auto px-4">
        
        <div class="glass-panel p-8 rounded-3xl border border-slate-200 bg-white shadow-2xl space-y-6">
            
            <div class="text-center space-y-2">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-700 to-cyan-500 text-white font-black text-2xl mx-auto flex items-center justify-center shadow-lg shadow-blue-600/30">
                    C
                </div>
                <h1 class="font-display text-2xl font-black text-slate-900">Buat Akun Baru</h1>
                <p class="text-xs text-slate-500 font-semibold">Bergabung dengan komunitas CanneShop Apparel</p>
            </div>

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-300 text-rose-800 text-xs p-3 rounded-2xl font-semibold space-y-1">
                    @foreach($errors->all() as $err)
                        <p>• {{ $err }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: Rian Nurbasari" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="nama@email.com" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Handphone / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="081234567890" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password *</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="Ketik ulang password" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-black py-3.5 rounded-2xl shadow-xl shadow-blue-600/30 flex items-center justify-center gap-2 text-sm transition-all transform hover:-translate-y-0.5">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>Daftar Akun</span>
                </button>
            </form>

            <div class="text-center pt-2 text-xs text-slate-500 font-semibold">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-600 font-black hover:underline">Masuk / Login</a>
            </div>

        </div>

    </div>
</div>
@endsection
