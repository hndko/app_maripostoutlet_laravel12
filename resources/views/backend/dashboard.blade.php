@extends('layout.app-backend')

@section('title', 'Dashboard')

@section('sidebar')
@if(Auth::user()->role === 'superadmin')
@include('backend.partials.sidebar-superadmin')
@else
@include('backend.partials.sidebar-owner')
@endif
@endsection

@section('content')
{{-- Welcome Banner --}}
<div class="bg-gradient-to-r from-primary-600 to-accent-600 rounded-2xl p-6 mb-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-1">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-primary-100">{{ now()->format('l, d F Y') }}</p>
        </div>
        <div class="hidden md:block">
            <i class="fas fa-chart-line text-6xl text-white/20"></i>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    @if(Auth::user()->role === 'superadmin')
    {{-- Superadmin Stats --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-blue-500">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['total_users'] ?? 0 }}</div>
            <div class="text-sm text-slate-500">Total Users</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-green-500">
            <i class="fas fa-store"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['total_outlets'] ?? 0 }}</div>
            <div class="text-sm text-slate-500">Total Outlets</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-purple-500">
            <i class="fas fa-crown"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['active_subscriptions'] ?? 0 }}</div>
            <div class="text-sm text-slate-500">Active Subscriptions</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-amber-500">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-slate-900">{{ formatRupiah($stats['total_revenue'] ?? 0) }}</div>
            <div class="text-sm text-slate-500">Total Revenue</div>
        </div>
    </div>
    @else
    {{-- Owner Stats --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-blue-500">
            <i class="fas fa-store"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['total_outlets'] ?? 0 }}</div>
            <div class="text-sm text-slate-500">Outlets</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-green-500">
            <i class="fas fa-box"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['total_products'] ?? 0 }}</div>
            <div class="text-sm text-slate-500">Produk</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-purple-500">
            <i class="fas fa-receipt"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['today_transactions'] ?? 0 }}</div>
            <div class="text-sm text-slate-500">Transaksi Hari Ini</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-amber-500">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-slate-900">{{ formatRupiah($stats['today_revenue'] ?? 0) }}</div>
            <div class="text-sm text-slate-500">Pendapatan Hari Ini</div>
        </div>
    </div>
    @endif
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200 font-semibold text-slate-700 flex items-center gap-2">
            <i class="fas fa-bolt text-amber-500"></i>
            Aksi Cepat
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-3">
                @if(Auth::user()->role === 'superadmin')
                <a href="{{ route('superadmin.users.create') }}"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-user-plus text-blue-500"></i>
                    <span class="font-medium text-slate-700">Tambah User</span>
                </a>
                <a href="{{ route('superadmin.subscription-packages.create') }}"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-plus-circle text-green-500"></i>
                    <span class="font-medium text-slate-700">Package Baru</span>
                </a>
                @else
                <a href="{{ route('pos.index') }}"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-cash-register text-primary-500"></i>
                    <span class="font-medium text-slate-700">Buka POS</span>
                </a>
                <a href="{{ route('owner.outlets.create') }}"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-store text-green-500"></i>
                    <span class="font-medium text-slate-700">Tambah Outlet</span>
                </a>
                <a href="{{ route('owner.cashiers.create') }}"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-user-plus text-blue-500"></i>
                    <span class="font-medium text-slate-700">Tambah Kasir</span>
                </a>
                <a href="{{ route('owner.reports.sales') }}"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-chart-line text-purple-500"></i>
                    <span class="font-medium text-slate-700">Lihat Laporan</span>
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Subscription Status (Owner Only) --}}
    @if(Auth::user()->role === 'owner')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200 font-semibold text-slate-700 flex items-center gap-2">
            <i class="fas fa-crown text-amber-500"></i>
            Status Subscription
        </div>
        <div class="p-6">
            @if($subscription ?? false)
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-600">Paket</span>
                <span class="font-semibold text-slate-800">{{ $subscription->package->name ?? '-' }}</span>
            </div>
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-600">Status</span>
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                    {{ ucfirst($subscription->status) }}
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-slate-600">Berakhir</span>
                <span class="font-semibold text-slate-800">{{ $subscription->end_date?->format('d M Y') ?? 'Lifetime'
                    }}</span>
            </div>
            @else
            <div class="text-center py-4">
                <i class="fas fa-exclamation-triangle text-4xl text-amber-400 mb-3"></i>
                <p class="text-slate-600 mb-3">Tidak ada subscription aktif</p>
                <a href="{{ route('owner.subscription.packages') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pilih Paket</span>
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection