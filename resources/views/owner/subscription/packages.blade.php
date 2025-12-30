@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="mb-4">
    <a href="{{ route('owner.subscription.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row g-4">
    @foreach($packages as $package)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 {{ $package->is_featured ? 'border-primary' : '' }}">
            @if($package->is_featured)
            <div class="card-header bg-primary text-white text-center">
                <i class="bi bi-star-fill me-1"></i>Paling Populer
            </div>
            @endif
            <div class="card-body text-center">
                <h4 class="mb-1">{{ $package->name }}</h4>
                <p class="text-muted small">{{ $package->description }}</p>

                <div class="py-4">
                    <h2 class="display-6 fw-bold text-primary mb-0">{{ formatRupiah($package->price) }}</h2>
                    @if($package->type == 'duration')
                    <small class="text-muted">/ {{ $package->duration_days }} hari</small>
                    @elseif($package->type == 'lifetime')
                    <small class="text-muted">Selamanya</small>
                    @endif
                </div>

                <ul class="list-unstyled text-start mb-4">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ $package->max_outlets
                        }} Outlet</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ $package->max_cashiers
                        }} Kasir</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ $package->max_products
                        ?? '∞' }} Produk</li>
                    @if($package->features)
                    @foreach($package->features as $feature)
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ $feature }}</li>
                    @endforeach
                    @endif
                </ul>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('owner.subscription.checkout', $package->id) }}"
                    class="btn btn-{{ $package->is_featured ? 'primary' : 'outline-primary' }} w-100">
                    <i class="bi bi-bag me-1"></i>Pilih Paket
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection