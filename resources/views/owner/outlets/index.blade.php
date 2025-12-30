@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-shop me-2"></i>Daftar Outlet</span>
        <a href="{{ route('owner.outlets.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>Tambah Outlet
        </a>
    </div>
    <div class="card-body">
        <div class="row g-4">
            @foreach($outlets as $outlet)
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 border">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <img src="{{ $outlet->logo ? Storage::url($outlet->logo) : asset('assets/backend/img/default-outlet.png') }}"
                                alt="{{ $outlet->name }}" class="rounded" width="60" height="60"
                                style="object-fit: cover;">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $outlet->name }}</h5>
                                <span class="badge bg-{{ $outlet->is_active ? 'success' : 'secondary' }}">
                                    {{ $outlet->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </div>
                        </div>

                        <p class="text-muted small mb-3">
                            <i class="bi bi-geo-alt me-1"></i>{{ $outlet->address ?? 'Alamat belum diisi' }}
                        </p>

                        <div class="row g-2 text-center mb-3">
                            <div class="col-4">
                                <div class="bg-light rounded p-2">
                                    <strong>{{ $outlet->products_count }}</strong>
                                    <br><small class="text-muted">Produk</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded p-2">
                                    <strong>{{ $outlet->transactions_count }}</strong>
                                    <br><small class="text-muted">Transaksi</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded p-2">
                                    <i class="bi bi-{{ $outlet->phone ? 'check text-success' : 'x text-muted' }}"></i>
                                    <br><small class="text-muted">Telepon</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('owner.products.index', $outlet->id) }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-seam me-1"></i>Produk
                            </a>
                            <a href="{{ route('owner.categories.index', $outlet->id) }}"
                                class="btn btn-outline-info btn-sm">
                                <i class="bi bi-tags me-1"></i>Kategori
                            </a>
                            <div class="btn-group btn-group-sm ms-auto">
                                <a href="{{ route('owner.outlets.edit', $outlet->id) }}"
                                    class="btn btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('owner.outlets.toggle-active', $outlet->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn btn-outline-{{ $outlet->is_active ? 'warning' : 'success' }}">
                                        <i class="bi bi-{{ $outlet->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection