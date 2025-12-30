@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-shop me-2"></i>Pilih Outlet
    </div>
    <div class="card-body">
        <div class="row g-4">
            @foreach($outlets as $outlet)
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('pos.outlet', $outlet->id) }}" class="card h-100 text-decoration-none border">
                    <div class="card-body text-center">
                        <img src="{{ $outlet->logo ? Storage::url($outlet->logo) : asset('assets/backend/img/default-outlet.png') }}"
                            alt="{{ $outlet->name }}" class="rounded mb-3" width="80" height="80"
                            style="object-fit: cover;">
                        <h5 class="mb-1">{{ $outlet->name }}</h5>
                        <p class="text-muted small mb-0">{{ $outlet->address ?? 'Alamat belum diisi' }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection