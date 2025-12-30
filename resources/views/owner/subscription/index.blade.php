@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-star me-2"></i>Status Langganan Anda
            </div>
            <div class="card-body">
                @if($subscription)
                <div class="d-flex align-items-center gap-4 mb-4">
                    <div class="stat-icon {{ $subscription->isActive() ? 'success' : 'danger' }}"
                        style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="bi bi-{{ $subscription->isActive() ? 'check-circle' : 'x-circle' }}"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $subscription->package->name }}</h3>
                        <p class="mb-0">
                            @if($subscription->isActive())
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-danger">Tidak Aktif</span>
                            @endif

                            @if($subscription->package->type == 'lifetime')
                            <span class="badge bg-primary">Selamanya</span>
                            @elseif($remainingDays !== null)
                            @if($remainingDays <= 7) <span class="badge bg-warning text-dark">{{ $remainingDays }} hari
                                tersisa</span>
                                @else
                                <span class="badge bg-info">{{ $remainingDays }} hari tersisa</span>
                                @endif
                                @endif
                        </p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3 text-center">
                            <h4 class="mb-0">{{ $subscription->package->max_outlets }}</h4>
                            <small class="text-muted">Maks Outlet</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3 text-center">
                            <h4 class="mb-0">{{ $subscription->package->max_cashiers }}</h4>
                            <small class="text-muted">Maks Kasir</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3 text-center">
                            <h4 class="mb-0">{{ $subscription->package->max_products ?? '∞' }}</h4>
                            <small class="text-muted">Maks Produk</small>
                        </div>
                    </div>
                </div>

                @if(!$subscription->package->isLifetime())
                <div class="mt-4">
                    <a href="{{ route('owner.subscription.packages') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-up-circle me-1"></i>Upgrade / Perpanjang
                    </a>
                </div>
                @endif
                @else
                <div class="text-center py-4">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Anda belum memiliki langganan aktif</h4>
                    <p class="text-muted">Pilih paket langganan untuk mulai menggunakan semua fitur.</p>
                    <a href="{{ route('owner.subscription.packages') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-bag me-1"></i>Lihat Paket Langganan
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-clock-history me-2"></i>Riwayat Pembayaran
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Paket</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                            <tr>
                                <td><code>{{ $payment->invoice_number }}</code></td>
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
                                    @default
                                    <span class="badge bg-secondary">{{ $payment->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat pembayaran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-gift me-2"></i>Fitur Paket Anda
            </div>
            <div class="card-body">
                @if($subscription && $subscription->package->features)
                <ul class="list-unstyled mb-0">
                    @foreach($subscription->package->features as $feature)
                    <li class="mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>{{ $feature }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted mb-0">Tidak ada fitur yang tersedia</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection