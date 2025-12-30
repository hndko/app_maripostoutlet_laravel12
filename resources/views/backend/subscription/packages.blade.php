@extends('layout.app-backend')

@section('title', 'Pilih Paket')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="mb-6">
    <nav class="text-sm text-slate-500 mb-1">
        <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('owner.subscription.index') }}" class="hover:text-primary-600">Subscription</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Pilih Paket</span>
    </nav>
    <h2 class="text-xl font-bold text-slate-800 text-center">Pilih Paket Subscription</h2>
    <p class="text-slate-500 text-center">Pilih paket yang sesuai dengan kebutuhan bisnis Anda</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
    @foreach($packages as $pkg)
    <div
        class="bg-white rounded-xl shadow-sm border-2 {{ $pkg->is_recommended ?? false ? 'border-primary-500' : 'border-slate-200' }} overflow-hidden relative">
        @if($pkg->is_recommended ?? false)
        <div class="absolute top-4 right-4">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary-500 text-white">
                <i class="fas fa-star mr-1"></i> Recommended
            </span>
        </div>
        @endif

        <div class="p-6 text-center border-b border-slate-200">
            <h3 class="font-bold text-xl text-slate-800 mb-2">{{ $pkg->name }}</h3>
            <div class="text-3xl font-bold text-primary-600 mb-1">{{ formatRupiah($pkg->price) }}</div>
            <div class="text-slate-500 text-sm">{{ $pkg->duration_days ? $pkg->duration_days.' hari' : 'Lifetime' }}
            </div>
        </div>

        <div class="p-6">
            <ul class="space-y-3 mb-6">
                <li class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fas fa-check text-green-500"></i>
                    {{ $pkg->features['outlets'] ?? '1' }} Outlet
                </li>
                <li class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fas fa-check text-green-500"></i>
                    {{ $pkg->features['products'] ?? '50' }} Produk
                </li>
                <li class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fas fa-check text-green-500"></i>
                    {{ $pkg->features['cashiers'] ?? '2' }} Kasir
                </li>
                <li class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fas fa-check text-green-500"></i>
                    Laporan Lengkap
                </li>
            </ul>

            <a href="{{ route('owner.subscription.checkout', $pkg->id) }}"
                class="block w-full text-center py-2.5 rounded-lg font-medium {{ $pkg->is_recommended ?? false ? 'bg-primary-600 text-white hover:bg-primary-700' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }} transition-colors">
                <i class="fas fa-shopping-cart mr-1"></i> Pilih Paket
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection