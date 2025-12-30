@extends('layout.app-backend')

@section('title', 'Subscription')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="mb-6">
    <nav class="text-sm text-slate-500 mb-1">
        <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Subscription</span>
    </nav>
    <h2 class="text-xl font-bold text-slate-800">Status Subscription</h2>
</div>

@if($subscription)
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Current Plan --}}
    <div class="lg:col-span-2">
        <div class="bg-gradient-to-r from-primary-600 to-accent-600 rounded-xl p-6 text-white mb-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-primary-200 text-sm mb-1">Paket Saat Ini</p>
                    <h3 class="text-2xl font-bold mb-2">{{ $subscription->package->name ?? 'Unknown' }}</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20">
                        <i
                            class="fas fa-{{ $subscription->isActive() ? 'check-circle' : 'exclamation-circle' }} mr-1"></i>
                        {{ ucfirst($subscription->status) }}
                    </span>
                </div>
                <div class="text-right">
                    <i class="fas fa-crown text-4xl text-white/30"></i>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 text-center">
                <div class="text-2xl font-bold text-slate-800">{{ $subscription->getRemainingDays() ?? '∞' }}</div>
                <div class="text-sm text-slate-500">Hari Tersisa</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 text-center">
                <div class="text-2xl font-bold text-slate-800">{{ $subscription->package->features['outlets'] ?? '∞' }}
                </div>
                <div class="text-sm text-slate-500">Max Outlets</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 text-center">
                <div class="text-2xl font-bold text-slate-800">{{ $subscription->package->features['products'] ?? '∞' }}
                </div>
                <div class="text-sm text-slate-500">Max Produk</div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3">
            <a href="{{ route('owner.subscription.packages') }}"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
                <i class="fas fa-arrow-up"></i> Upgrade
            </a>
        </div>
    </div>

    {{-- Details --}}
    <div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h4 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-primary-500"></i>
                Detail Subscription
            </h4>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-slate-500">Mulai</span>
                    <span class="font-medium text-slate-800">{{ $subscription->start_date?->format('d M Y') ?? '-'
                        }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Berakhir</span>
                    <span class="font-medium text-slate-800">{{ $subscription->end_date?->format('d M Y') ?? 'Lifetime'
                        }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Status</span>
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $subscription->isActive() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($subscription->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <i class="fas fa-crown text-5xl text-slate-300 mb-4"></i>
    <h3 class="text-lg font-semibold text-slate-800 mb-2">Tidak Ada Subscription Aktif</h3>
    <p class="text-slate-500 mb-4">Pilih paket untuk mulai menggunakan fitur lengkap</p>
    <a href="{{ route('owner.subscription.packages') }}"
        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
        <i class="fas fa-shopping-cart"></i> Lihat Paket
    </a>
</div>
@endif
@endsection