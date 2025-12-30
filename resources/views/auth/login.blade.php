@extends('layout.app-auth')

@section('title', 'Login')

@section('content')
<form action="{{ route('login.post') }}" method="POST" class="space-y-5">
    @csrf

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Selamat Datang</h2>
        <p class="text-slate-500 text-sm">Masuk ke akun Anda</p>
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-envelope mr-1 text-slate-400"></i> Email
        </label>
        <input type="email" name="email" value="{{ old('email') }}"
            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all @error('email') border-red-500 @enderror"
            placeholder="email@example.com" required autofocus>
        @error('email')
        <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
        @enderror
    </div>

    {{-- Password --}}
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-lock mr-1 text-slate-400"></i> Password
        </label>
        <div x-data="{ show: false }" class="relative">
            <input :type="show ? 'text' : 'password'" name="password"
                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all pr-10 @error('password') border-red-500 @enderror"
                placeholder="••••••••" required>
            <button type="button" @click="show = !show"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
            </button>
        </div>
        @error('password')
        <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
        @enderror
    </div>

    {{-- Remember --}}
    <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember"
                class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
            <span class="text-sm text-slate-600">Ingat saya</span>
        </label>
        <a href="#" class="text-sm text-primary-600 hover:text-primary-700">Lupa password?</a>
    </div>

    {{-- Submit --}}
    <button type="submit"
        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800 shadow-sm transition-all">
        <i class="fas fa-sign-in-alt"></i>
        <span>Masuk</span>
    </button>

    {{-- Register Link --}}
    <p class="text-center text-sm text-slate-500">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">Daftar
            sekarang</a>
    </p>
</form>
@endsection