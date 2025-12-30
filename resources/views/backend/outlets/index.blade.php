@extends('layout.app-backend')

@section('title', 'Outlets')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Outlets</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">Daftar Outlet</h2>
    </div>
    <a href="{{ route('owner.outlets.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700 transition-all">
        <i class="fas fa-plus-circle"></i>
        <span>Tambah Outlet</span>
    </a>
</div>

{{-- Outlets Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($outlets as $outlet)
    <div
        class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
        {{-- Logo --}}
        <div class="h-32 bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
            @if($outlet->logo)
            <img src="{{ Storage::url($outlet->logo) }}" alt="{{ $outlet->name }}"
                class="h-20 w-20 rounded-full object-cover border-4 border-white shadow">
            @else
            <div class="h-20 w-20 rounded-full bg-white/20 flex items-center justify-center">
                <i class="fas fa-store text-3xl text-white"></i>
            </div>
            @endif
        </div>

        {{-- Content --}}
        <div class="p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-bold text-lg text-slate-800">{{ $outlet->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $outlet->address ?? 'Alamat belum diisi' }}</p>
                </div>
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $outlet->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $outlet->is_active ? 'Aktif' : 'Non-Aktif' }}
                </span>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-2 mb-4">
                <div class="text-center p-2 bg-slate-50 rounded-lg">
                    <div class="font-bold text-slate-800">{{ $outlet->products_count ?? 0 }}</div>
                    <div class="text-xs text-slate-500">Produk</div>
                </div>
                <div class="text-center p-2 bg-slate-50 rounded-lg">
                    <div class="font-bold text-slate-800">{{ $outlet->categories_count ?? 0 }}</div>
                    <div class="text-xs text-slate-500">Kategori</div>
                </div>
                <div class="text-center p-2 bg-slate-50 rounded-lg">
                    <div class="font-bold text-slate-800">{{ $outlet->transactions_count ?? 0 }}</div>
                    <div class="text-xs text-slate-500">Transaksi</div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-2">
                <a href="{{ route('pos.outlet', $outlet->id) }}"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium bg-primary-600 text-white hover:bg-primary-700 transition-all">
                    <i class="fas fa-cash-register"></i> POS
                </a>
                <a href="{{ route('owner.outlets.show', $outlet->id) }}"
                    class="px-3 py-2 rounded-lg text-sm border border-slate-300 text-slate-600 hover:bg-slate-50 transition-all">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('owner.outlets.edit', $outlet->id) }}"
                    class="px-3 py-2 rounded-lg text-sm border border-slate-300 text-slate-600 hover:bg-slate-50 transition-all">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
            <i class="fas fa-store text-5xl text-slate-300 mb-4"></i>
            <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Outlet</h3>
            <p class="text-slate-500 mb-4">Tambahkan outlet pertama Anda untuk mulai berjualan</p>
            <a href="{{ route('owner.outlets.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700 transition-all">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Outlet</span>
            </a>
        </div>
    </div>
    @endforelse
</div>
@endsection