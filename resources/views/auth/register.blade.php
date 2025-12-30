@extends('layout.app-auth')

@section('title', 'Register')

@section('content')
<form action="{{ route('register.post') }}" method="POST" class="space-y-4">
    @csrf

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Buat Akun</h2>
        <p class="text-slate-500 text-sm">Daftar sebagai owner outlet</p>
    </div>

    {{-- Name --}}
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-user mr-1 text-slate-400"></i> Nama Lengkap
        </label>
        <input type="text" name="name" value="{{ old('name') }}"
            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all @error('name') border-red-500 @enderror"
            placeholder="Nama lengkap" required>
        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-envelope mr-1 text-slate-400"></i> Email
        </label>
        <input type="email" name="email" value="{{ old('email') }}"
            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all @error('email') border-red-500 @enderror"
            placeholder="email@example.com" required>
        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- Phone --}}
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-phone mr-1 text-slate-400"></i> No. Telepon
        </label>
        <input type="tel" name="phone" value="{{ old('phone') }}"
            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all"
            placeholder="08xxxxxxxxxx">
    </div>

    {{-- Password --}}
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-lock mr-1 text-slate-400"></i> Password
        </label>
        <input type="password" name="password"
            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all @error('password') border-red-500 @enderror"
            placeholder="Min. 8 karakter" required>
        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- Confirm Password --}}
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-lock mr-1 text-slate-400"></i> Konfirmasi Password
        </label>
        <input type="password" name="password_confirmation"
            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all"
            placeholder="Ulangi password" required>
    </div>

    {{-- Terms --}}
    <label class="flex items-start gap-2 cursor-pointer">
        <input type="checkbox" name="terms" class="w-4 h-4 mt-0.5 rounded border-slate-300 text-primary-600" required>
        <span class="text-sm text-slate-600">Saya setuju dengan <a href="#" class="text-primary-600">Syarat &
                Ketentuan</a></span>
    </label>

    {{-- Submit --}}
    <button type="submit"
        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800 shadow-sm transition-all">
        <i class="fas fa-user-plus"></i>
        <span>Daftar</span>
    </button>

    {{-- Login Link --}}
    <p class="text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-primary-600 font-medium">Masuk</a>
    </p>
</form>
@endsection