@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h1><i class="bi bi-shop me-2"></i>{{ setting('website_name', 'Maripos Outlet') }}</h1>
        <p>Daftar akun baru sebagai Owner</p>
    </div>

    <div class="auth-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle me-2"></i>
            @foreach($errors->all() as $error)
            {{ $error }}<br>
            @endforeach
        </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="form-floating-icon">
                <i class="bi bi-person input-icon"></i>
                <div class="form-floating">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap"
                        value="{{ old('name') }}" required autofocus>
                    <label for="name">Nama Lengkap</label>
                </div>
            </div>

            <div class="form-floating-icon">
                <i class="bi bi-envelope input-icon"></i>
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                        value="{{ old('email') }}" required>
                    <label for="email">Email</label>
                </div>
            </div>

            <div class="form-floating-icon">
                <i class="bi bi-phone input-icon"></i>
                <div class="form-floating">
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="No. Telepon"
                        value="{{ old('phone') }}">
                    <label for="phone">No. Telepon (Opsional)</label>
                </div>
            </div>

            <div class="form-floating-icon">
                <i class="bi bi-lock input-icon"></i>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required>
                    <label for="password">Password</label>
                </div>
            </div>

            <div class="form-floating-icon">
                <i class="bi bi-lock-fill input-icon"></i>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Konfirmasi Password" required>
                    <label for="password_confirmation">Konfirmasi Password</label>
                </div>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="terms" required>
                <label class="form-check-label" for="terms">
                    Saya setuju dengan <a href="#" target="_blank">syarat dan ketentuan</a>
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
            </button>
        </form>

        <div class="divider">
            <span>atau</span>
        </div>

        <a href="{{ route('auth.provider.redirect', 'google') }}" class="btn-social">
            <img src="https://www.google.com/favicon.ico" alt="Google">
            Daftar dengan Google
        </a>
    </div>

    <div class="auth-footer">
        <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>
</div>
@endsection