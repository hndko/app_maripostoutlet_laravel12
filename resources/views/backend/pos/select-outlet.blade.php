@extends('layout.app-backend')

@section('title', 'POS - Pilih Outlet')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">
        <i class="fas fa-cash-register text-primary-500 mr-2"></i>
        Pilih Outlet
    </h2>
    <p class="text-slate-500">Pilih outlet untuk memulai transaksi POS</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl mx-auto">
    @forelse($outlets as $outlet)
    <a href="{{ route('pos.outlet', $outlet->id) }}"
        class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 text-center hover:shadow-lg hover:-translate-y-1 transition-all">
        <div
            class="w-16 h-16 bg-gradient-to-br from-primary-500 to-accent-500 rounded-xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-store text-2xl text-white"></i>
        </div>
        <h3 class="font-bold text-lg text-slate-800 mb-1">{{ $outlet->name }}</h3>
        <p class="text-sm text-slate-500 mb-3">{{ $outlet->products_count ?? 0 }} produk</p>
        <span class="inline-flex items-center gap-1 text-primary-600 font-medium text-sm">
            <span>Masuk POS</span>
            <i class="fas fa-arrow-right"></i>
        </span>
    </a>
    @empty
    <div class="col-span-full text-center py-12">
        <i class="fas fa-store text-5xl text-slate-300 mb-4"></i>
        <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Outlet</h3>
        <p class="text-slate-500 mb-4">Buat outlet terlebih dahulu</p>
        <a href="{{ route('owner.outlets.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
            <i class="fas fa-plus-circle"></i> Tambah Outlet
        </a>
    </div>
    @endforelse
</div>
@endsection