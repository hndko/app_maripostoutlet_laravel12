@extends('layout.app-auth')

@section('title', 'Login')

@section('content')
<div>
    <h2 class="text-xl font-bold text-slate-800 mb-1">Selamat Datang</h2>
    <p class="text-slate-500 text-sm mb-6">Masuk ke akun Anda untuk melanjutkan</p>

    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">
                <i class="fas fa-envelope mr-1 text-slate-400"></i> Email
            </label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all @error('email') border-red-500 @enderror"
                placeholder="email@example.com" required autofocus>
            @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">
                <i class="fas fa-lock mr-1 text-slate-400"></i> Password
            </label>
            <div x-data="{ show: false }" class="relative">
                <input :type="show ? 'text' : 'password'" name="password"
                    class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all pr-10 @error('password') border-red-500 @enderror"
                    placeholder="••••••••" required>
                <button type="button" @click="show = !show"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                    <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                </button>
            </div>
            @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember & Forgot --}}
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember"
                    class="w-3.5 h-3.5 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                <span class="text-xs text-slate-600">Ingat saya</span>
            </label>
            <a href="#" class="text-xs text-primary-600 hover:text-primary-700">Lupa password?</a>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800 shadow-sm transition-all">
            <i class="fas fa-sign-in-alt"></i>
            <span>Masuk</span>
        </button>
    </form>

    {{-- Divider --}}
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="px-2 bg-slate-100 text-slate-500">atau</span>
        </div>
    </div>

    {{-- Register Link --}}
    <p class="text-center text-sm text-slate-600">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">Daftar
            sekarang</a>
    </p>
</div>
@endsection