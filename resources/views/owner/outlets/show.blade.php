@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $outlet->logo ? Storage::url($outlet->logo) : asset('assets/backend/img/default-outlet.png') }}"
                    alt="{{ $outlet->name }}" class="rounded mb-3" width="120" height="120" style="object-fit: cover;">
                <h4 class="mb-1">{{ $outlet->name }}</h4>
                <span class="badge bg-{{ $outlet->is_active ? 'success' : 'secondary' }}">
                    {{ $outlet->is_active ? 'Aktif' : 'Non-Aktif' }}
                </span>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <p class="mb-1"><i class="bi bi-phone me-2"></i>{{ $outlet->phone ?? '-' }}</p>
                <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>{{ $outlet->address ?? '-' }}</p>
            </div>
            <div class="card-footer">
                <div class="d-flex gap-2">
                    <a href="{{ route('owner.outlets.edit', $outlet->id) }}" class="btn btn-primary btn-sm flex-fill">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('owner.outlets.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="row g-3 mb-3">
            <div class="col-4">
                <div class="stat-card">
                    <div class="stat-icon primary"><i class="bi bi-box-seam"></i></div>
                    <div class="stat-info">
                        <h3>{{ $outlet->products_count }}</h3>
                        <p>Produk</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card">
                    <div class="stat-icon info"><i class="bi bi-tags"></i></div>
                    <div class="stat-info">
                        <h3>{{ $outlet->categories_count }}</h3>
                        <p>Kategori</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card">
                    <div class="stat-icon success"><i class="bi bi-receipt"></i></div>
                    <div class="stat-info">
                        <h3>{{ $outlet->transactions_count }}</h3>
                        <p>Transaksi</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="bi bi-lightning me-2"></i>Kelola Outlet</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6 col-md-4">
                        <a href="{{ route('owner.products.index', $outlet->id) }}"
                            class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-box-seam d-block mb-2" style="font-size: 1.5rem;"></i>
                            Produk
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('owner.categories.index', $outlet->id) }}"
                            class="btn btn-outline-info w-100 py-3">
                            <i class="bi bi-tags d-block mb-2" style="font-size: 1.5rem;"></i>
                            Kategori
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('owner.payment-methods.index', $outlet->id) }}"
                            class="btn btn-outline-success w-100 py-3">
                            <i class="bi bi-credit-card d-block mb-2" style="font-size: 1.5rem;"></i>
                            Pembayaran
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('owner.discounts.index', $outlet->id) }}"
                            class="btn btn-outline-warning w-100 py-3">
                            <i class="bi bi-percent d-block mb-2" style="font-size: 1.5rem;"></i>
                            Diskon
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('pos.outlet', $outlet->id) }}" class="btn btn-primary w-100 py-3">
                            <i class="bi bi-calculator d-block mb-2" style="font-size: 1.5rem;"></i>
                            Buka POS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection