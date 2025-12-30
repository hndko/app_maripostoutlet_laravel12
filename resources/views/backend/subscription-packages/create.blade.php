@extends('layout.app-backend')

@section('title', 'Tambah Package')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superadmin.subscription-packages.index') }}">Packages</a>
            </li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
        <h1 class="page-header mb-0">Tambah Package</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('superadmin.subscription-packages.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipe <span class="text-danger">*</span></label>
                    <select class="form-select" name="type" required>
                        <option value="trial">Trial</option>
                        <option value="duration">Duration</option>
                        <option value="lifetime">Lifetime</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga</label>
                    <input type="number" class="form-control" name="price" value="{{ old('price', 0) }}" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Durasi (hari)</label>
                    <input type="number" class="form-control" name="duration_days" value="{{ old('duration_days') }}"
                        min="1">
                </div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea class="form-control"
                        name="description" rows="2">{{ old('description') }}</textarea></div>
                <div class="col-md-4"><label class="form-label">Max Outlets</label><input type="number"
                        class="form-control" name="features[outlets]" value="1" min="1"></div>
                <div class="col-md-4"><label class="form-label">Max Products</label><input type="number"
                        class="form-control" name="features[products]" value="50" min="1"></div>
                <div class="col-md-4"><label class="form-label">Max Cashiers</label><input type="number"
                        class="form-control" name="features[cashiers]" value="2" min="1"></div>
            </div>
            <hr>
            <button type="submit" class="btn btn-theme"><i class="fa fa-save me-1"></i> Simpan</button>
            <a href="{{ route('superadmin.subscription-packages.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection