@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
{{-- Subscription Warning --}}
@if($isExpiringSoon && $subscription)
<div class="subscription-banner">
    <div>
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Langganan Anda akan habis dalam {{ $remainingDays }} hari!</strong>
        <span class="ms-2">Perpanjang sekarang untuk tetap menggunakan layanan.</span>
    </div>
    <a href="{{ route('owner.subscription.packages') }}" class="btn btn-light btn-sm">
        <i class="bi bi-arrow-right me-1"></i>Perpanjang
    </a>
</div>
@endif

<div class="row g-4 mb-4">
    {{-- Total Outlet --}}
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="bi bi-shop"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalOutlets) }}</h3>
                <p>Total Outlet</p>
            </div>
        </div>
    </div>

    {{-- Total Produk --}}
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalProducts) }}</h3>
                <p>Total Produk</p>
            </div>
        </div>
    </div>

    {{-- Total Kasir --}}
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalCashiers) }}</h3>
                <p>Total Kasir</p>
            </div>
        </div>
    </div>

    {{-- Transaksi Hari Ini --}}
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="bi bi-receipt"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($todayTransactions) }}</h3>
                <p>Transaksi Hari Ini</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Revenue Cards --}}
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-calendar-day text-primary" style="font-size: 2rem;"></i>
                <h3 class="mt-3 mb-1">{{ formatRupiah($todayRevenue) }}</h3>
                <p class="text-muted mb-0">Pendapatan Hari Ini</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-calendar-week text-success" style="font-size: 2rem;"></i>
                <h3 class="mt-3 mb-1">{{ formatRupiah($weeklyRevenue) }}</h3>
                <p class="text-muted mb-0">Pendapatan Minggu Ini</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-calendar-month text-info" style="font-size: 2rem;"></i>
                <h3 class="mt-3 mb-1">{{ formatRupiah($monthlyRevenue) }}</h3>
                <p class="text-muted mb-0">Pendapatan Bulan Ini</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Daftar Outlet --}}
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-shop me-2"></i>Outlet Anda</span>
                <a href="{{ route('owner.outlets.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($outlets as $outlet)
                    <a href="{{ route('owner.outlets.show', $outlet->id) }}"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $outlet->name }}</strong>
                            <br><small class="text-muted">{{ $outlet->products_count }} produk</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $outlet->transactions_count }} trx</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="col-12 col-xl-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-receipt me-2"></i>Transaksi Terbaru</span>
                <a href="{{ route('owner.transactions.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Outlet</th>
                                <th>Kasir</th>
                                <th>Total</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $trx)
                            <tr>
                                <td><code>{{ $trx->invoice_number }}</code></td>
                                <td>{{ $trx->outlet->name }}</td>
                                <td>{{ $trx->cashier->name }}</td>
                                <td>{{ formatRupiah($trx->total) }}</td>
                                <td>{{ $trx->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightning me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('pos.index') }}" class="btn btn-primary w-100 py-3">
                            <i class="bi bi-calculator d-block mb-2" style="font-size: 1.5rem;"></i>
                            Buka POS
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('owner.outlets.create') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-plus-circle d-block mb-2" style="font-size: 1.5rem;"></i>
                            Tambah Outlet
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('owner.cashiers.create') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-person-plus d-block mb-2" style="font-size: 1.5rem;"></i>
                            Tambah Kasir
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('owner.reports.sales') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-graph-up d-block mb-2" style="font-size: 1.5rem;"></i>
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection