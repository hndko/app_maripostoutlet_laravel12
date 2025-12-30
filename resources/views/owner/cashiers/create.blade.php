@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-person-plus me-2"></i>Tambah Kasir Baru
    </div>
    <div class="card-body">
        <form action="{{ route('owner.cashiers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Nama kasir" required>
                            </div>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                            </div>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Minimal 6 karakter" required>
                            </div>
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Ulangi password" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Foto Profil</label>
                    <div class="image-preview mb-3" id="avatarPreview">
                        <i class="bi bi-person-circle text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <input type="file" class="form-control" name="avatar" accept="image/*"
                        onchange="previewImage(this, 'avatarPreview')">
                    <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
                <a href="{{ route('owner.cashiers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x me-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection