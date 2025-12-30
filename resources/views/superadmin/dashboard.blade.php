@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-superadmin')
@endsection

@section('content')
<div class="row g-4 mb-4">
    {{-- Total Owners --}}
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalOwners) }}</h3>
                <p>Total Owner</p>
            </div>
        </div>
    </div>

    {{-- Total Kasir --}}
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($totalCashiers) }}</h3>
                <p>Total Kasir</p>
            </div>
        </div>
    </div>

    {{-- Langganan Aktif --}}
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($activeSubscriptions) }}</h3>
                <p>Langganan Aktif</p>
            </div>
        </div>
    </div>

    {{-- Pembayaran Pending --}}
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="bi bi-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($pendingPayments) }}</h3>
                <p>Pembayaran Pending</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Revenue Bulanan --}}
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-wallet2 me-2"></i>Revenue Bulan Ini</span>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div class="text-center">
                    <h2 class="display-5 fw-bold text-primary mb-0">{{ formatRupiah($monthlyRevenue) }}</h2>
                    <p class="text-muted">{{ now()->translatedFormat('F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Pembayaran Terbaru --}}
    <div class="col-12 col-xl-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-credit-card me-2"></i>Pembayaran Terbaru</span>
                <a href="{{ route('superadmin.subscription-payments.index') }}"
                    class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Owner</th>
                                <th>Paket</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPayments as $payment)
                            <tr>
                                <td><code>{{ $payment->invoice_number }}</code></td>
                                <td>{{ $payment->subscription->owner->name ?? '-' }}</td>
                                <td>{{ $payment->subscription->package->name ?? '-' }}</td>
                                <td>{{ formatRupiah($payment->amount) }}</td>
                                <td>
                                    @switch($payment->status)
                                    @case('paid')
                                    <span class="badge bg-success">Lunas</span>
                                    @break
                                    @case('pending')
                                    <span class="badge bg-warning">Pending</span>
                                    @break
                                    @case('failed')
                                    <span class="badge bg-danger">Gagal</span>
                                    @break
                                    @default
                                    <span class="badge bg-secondary">{{ $payment->status }}</span>
                                    @endswitch
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Langganan Akan Habis --}}
@if($expiringSubscriptions->count() > 0)
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <i class="bi bi-exclamation-triangle me-2"></i>Langganan Akan Habis (7 Hari)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Owner</th>
                                <th>Email</th>
                                <th>Paket</th>
                                <th>Berakhir</th>
                                <th>Sisa Hari</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiringSubscriptions as $sub)
                            <tr>
                                <td>{{ $sub->owner->name }}</td>
                                <td>{{ $sub->owner->email }}</td>
                                <td>{{ $sub->package->name }}</td>
                                <td>{{ $sub->end_date->translatedFormat('d M Y') }}</td>
                                <td><span class="badge bg-warning text-dark">{{ $sub->remainingDays() }} hari</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection