@extends('layout.app-auth')

@section('title', 'Register')

@section('content')
<div>
    <h2 class="text-xl font-bold text-slate-800 mb-1">Buat Akun</h2>
    <p class="text-slate-500 text-sm mb-6">Daftar sebagai owner outlet</p>

    <form action="{{ route('register.post') }}" method="POST" class="space-y-3">
        @csrf

        {{-- Name --}}
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">
                <i class="fas fa-user mr-1 text-slate-400"></i> Nama Lengkap
            </label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none @error('name') border-red-500 @enderror"
                placeholder="Nama lengkap" required>
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">
                <i class="fas fa-envelope mr-1 text-slate-400"></i> Email
            </label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none @error('email') border-red-500 @enderror"
                placeholder="email@example.com" required>
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Phone --}}
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">
                <i class="fas fa-phone mr-1 text-slate-400"></i> No. Telepon
            </label>
            <input type="tel" name="phone" value="{{ old('phone') }}"
                class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none"
                placeholder="08xxxxxxxxxx">
        </div>

        {{-- Password --}}
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">
                    <i class="fas fa-lock mr-1 text-slate-400"></i> Password
                </label>
                <input type="password" name="password"
                    class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none @error('password') border-red-500 @enderror"
                    placeholder="Min. 8 karakter" required>
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">
                    <i class="fas fa-lock mr-1 text-slate-400"></i> Konfirmasi
                </label>
                <input type="password" name="password_confirmation"
                    class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none"
                    placeholder="Ulangi password" required>
            </div>
        </div>

        {{-- Terms --}}
        <label class="flex items-start gap-2 cursor-pointer">
            <input type="checkbox" name="terms" class="w-3.5 h-3.5 mt-0.5 rounded border-slate-300 text-primary-600"
                required>
            <span class="text-xs text-slate-600">Saya setuju dengan <a href="#" class="text-primary-600">Syarat &
                    Ketentuan</a></span>
        </label>

        {{-- Submit --}}
        <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800 shadow-sm transition-all">
            <i class="fas fa-user-plus"></i>
            <span>Daftar</span>
        </button>
    </form>

    {{-- Login Link --}}
    <p class="text-center text-sm text-slate-600 mt-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-primary-600 font-medium">Masuk</a>
    </p>
</div>
@endsection