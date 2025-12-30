@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-pencil me-2"></i>Edit Outlet: {{ $outlet->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('owner.outlets.update', $outlet->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Nama Outlet <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $outlet->name) }}" required>
                            </div>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $outlet->phone) }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address"
                                rows="3">{{ old('address', $outlet->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Logo Outlet</label>
                    <div class="image-preview mb-3" id="logoPreview">
                        @if($outlet->logo)
                        <img src="{{ Storage::url($outlet->logo) }}" alt="{{ $outlet->name }}">
                        @else
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        @endif
                    </div>
                    <input type="file" class="form-control" name="logo" accept="image/*"
                        onchange="previewImage(this, 'logoPreview')">
                    <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Update
                </button>
                <a href="{{ route('owner.outlets.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x me-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection