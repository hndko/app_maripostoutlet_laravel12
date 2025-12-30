@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-pencil me-2"></i>Edit Kasir: {{ $cashier->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('owner.cashiers.update', $cashier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $cashier->name) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $cashier->email) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $cashier->phone) }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <hr>
                            <p class="text-muted mb-2">Kosongkan jika tidak ingin mengubah password</p>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Foto Profil</label>
                    <div class="image-preview mb-3" id="avatarPreview">
                        @if($cashier->avatar)
                        <img src="{{ Storage::url($cashier->avatar) }}" alt="{{ $cashier->name }}">
                        @else
                        <i class="bi bi-person-circle text-muted" style="font-size: 3rem;"></i>
                        @endif
                    </div>
                    <input type="file" class="form-control" name="avatar" accept="image/*"
                        onchange="previewImage(this, 'avatarPreview')">
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Update
                </button>
                <a href="{{ route('owner.cashiers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x me-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection