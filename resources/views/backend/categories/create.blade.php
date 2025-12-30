@extends('layout.app-backend')

@section('title', 'Tambah Kategori')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('owner.categories.index', $outlet->id) }}">Kategori</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
        <h1 class="page-header mb-0">Tambah Kategori</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('owner.categories.store', $outlet->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Urutan</label>
                    <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}"
                        min="0">
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-theme"><i class="fa fa-save me-1"></i> Simpan</button>
                <a href="{{ route('owner.categories.index', $outlet->id) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection