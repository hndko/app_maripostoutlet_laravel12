@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h1><i class="bi bi-shop me-2"></i>{{ setting('website_name', 'Maripos Outlet') }}</h1>
        <p>Masuk ke akun Anda</p>
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

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-floating-icon">
                <i class="bi bi-envelope input-icon"></i>
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                        value="{{ old('email') }}" required autofocus>
                    <label for="email">Email</label>
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>

        <div class="divider">
            <span>atau</span>
        </div>

        <a href="{{ route('auth.provider.redirect', 'google') }}" class="btn-social">
            <img src="https://www.google.com/favicon.ico" alt="Google">
            Masuk dengan Google
        </a>
    </div>

    <div class="auth-footer">
        <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
    </div>
</div>
@endsection