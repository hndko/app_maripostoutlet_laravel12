@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2"></i>Tambah Kategori - {{ $outlet->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('owner.categories.store', $outlet->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label">Nama Kategori <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Nama kategori" required>
                            </div>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="sort_order" class="form-label">Urutan</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order"
                                value="{{ old('sort_order', 0) }}" min="0">
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                placeholder="Deskripsi kategori (opsional)">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Gambar Kategori</label>
                    <div class="image-preview mb-3" id="imagePreview">
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <input type="file" class="form-control" name="image" accept="image/*"
                        onchange="previewImage(this, 'imagePreview')">
                    <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
                <a href="{{ route('owner.categories.index', $outlet->id) }}" class="btn btn-secondary">
                    <i class="bi bi-x me-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection