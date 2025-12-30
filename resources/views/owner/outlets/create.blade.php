@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2"></i>Tambah Outlet Baru
    </div>
    <div class="card-body">
        <form action="{{ route('owner.outlets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Nama Outlet <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Contoh: Outlet Cabang Jakarta"
                                    required>
                            </div>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                            </div>
                            @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address" rows="3"
                                placeholder="Alamat lengkap outlet">{{ old('address') }}</textarea>
                            @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Logo Outlet</label>
                    <div class="image-preview mb-3" id="logoPreview">
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo"
                        accept="image/*" onchange="previewImage(this, 'logoPreview')">
                    @error('logo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
                <a href="{{ route('owner.outlets.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x me-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection