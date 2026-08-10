@extends('layouts.app')

@section('title', 'Login - CanneShop Apparel')

@section('content')
<div class="py-16 bg-slate-50 min-h-[80vh] flex items-center justify-center">
    <div class="max-w-md w-full mx-auto px-4">
        
        <div class="glass-panel p-8 rounded-3xl border border-slate-200 bg-white shadow-2xl space-y-6">
            
            <div class="text-center space-y-2">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-700 to-cyan-500 text-white font-black text-2xl mx-auto flex items-center justify-center shadow-lg shadow-blue-600/30">
                    C
                </div>
                <h1 class="font-display text-2xl font-black text-slate-900">Selamat Datang Kembali</h1>
                <p class="text-xs text-slate-500 font-semibold">Masuk ke akun CanneShop Apparel kamu</p>
            </div>

            <!-- Demo Account Quick Login Box -->
            <div class="bg-blue-50/80 border border-blue-200 p-4 rounded-2xl space-y-2 text-xs">
                <div class="flex items-center justify-between">
                    <span class="font-black text-blue-800 uppercase tracking-wider text-[10px]">💡 AKUN DEMO SIAP PAKAI</span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <button type="button" onclick="fillDemo('admin@canne.shop', 'password')" class="bg-white hover:bg-blue-100 text-blue-700 border border-blue-300 px-3 py-2 rounded-xl text-[11px] font-black text-left shadow-sm transition-colors">
                        👑 Login Admin
                        <span class="block text-[9px] text-slate-500 font-normal">admin@canne.shop</span>
                    </button>
                    <button type="button" onclick="fillDemo('user@canne.shop', 'password')" class="bg-white hover:bg-blue-100 text-blue-700 border border-blue-300 px-3 py-2 rounded-xl text-[11px] font-black text-left shadow-sm transition-colors">
                        👤 Login User
                        <span class="block text-[9px] text-slate-500 font-normal">user@canne.shop</span>
                    </button>
                </div>
            </div>

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-300 text-rose-800 text-xs p-3 rounded-2xl font-semibold">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email *</label>
                    <input type="email" id="email-input" name="email" required value="{{ old('email') }}" placeholder="nama@email.com" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password *</label>
                    <input type="password" id="password-input" name="password" required placeholder="••••••••" class="w-full bg-slate-50 text-sm text-slate-900 px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-600 font-semibold">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-semibold">
                        <input type="checkbox" name="remember" class="accent-blue-600 rounded">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-black py-3.5 rounded-2xl shadow-xl shadow-blue-600/30 flex items-center justify-center gap-2 text-sm transition-all transform hover:-translate-y-0.5">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    <span>Masuk Akun</span>
                </button>
            </form>

            <div class="text-center pt-2 text-xs text-slate-500 font-semibold">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 font-black hover:underline">Daftar Sekarang</a>
            </div>

        </div>

    </div>
</div>

<script>
    function fillDemo(email, password) {
        document.getElementById('email-input').value = email;
        document.getElementById('password-input').value = password;
    }
</script>
@endsection
