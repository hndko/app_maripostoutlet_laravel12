@extends('layout.app-backend')

@section('title', $outlet->name)

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="mb-6">
    <nav class="text-sm text-slate-500 mb-1">
        <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('owner.outlets.index') }}" class="hover:text-primary-600">Outlets</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">{{ $outlet->name }}</span>
    </nav>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Outlet Info --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="h-32 bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
                @if($outlet->logo)
                <img src="{{ Storage::url($outlet->logo) }}" alt=""
                    class="h-20 w-20 rounded-full object-cover border-4 border-white shadow">
                @else
                <div class="h-20 w-20 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-store text-3xl text-white"></i>
                </div>
                @endif
            </div>
            <div class="p-5 text-center">
                <h3 class="font-bold text-xl text-slate-800 mb-1">{{ $outlet->name }}</h3>
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $outlet->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $outlet->is_active ? 'Aktif' : 'Non-Aktif' }}
                </span>
            </div>
            <div class="border-t border-slate-200 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <i class="fas fa-phone text-slate-400 w-5"></i>
                    <span class="text-slate-600">{{ $outlet->phone ?? '-' }}</span>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-map-marker-alt text-slate-400 w-5 mt-1"></i>
                    <span class="text-slate-600">{{ $outlet->address ?? 'Alamat belum diisi' }}</span>
                </div>
            </div>
            <div class="border-t border-slate-200 p-4 flex gap-2">
                <a href="{{ route('owner.outlets.edit', $outlet->id) }}"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm border border-slate-300 text-slate-600 hover:bg-slate-50">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('pos.outlet', $outlet->id) }}"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm bg-primary-600 text-white hover:bg-primary-700">
                    <i class="fas fa-cash-register"></i> POS
                </a>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="lg:col-span-2">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <a href="{{ route('owner.products.index', $outlet->id) }}"
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 text-center hover:shadow-md transition-shadow">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-box text-xl"></i>
                </div>
                <div class="font-bold text-2xl text-slate-800">{{ $outlet->products_count ?? 0 }}</div>
                <div class="text-sm text-slate-500">Produk</div>
            </a>

            <a href="{{ route('owner.categories.index', $outlet->id) }}"
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 text-center hover:shadow-md transition-shadow">
                <div
                    class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-tags text-xl"></i>
                </div>
                <div class="font-bold text-2xl text-slate-800">{{ $outlet->categories_count ?? 0 }}</div>
                <div class="text-sm text-slate-500">Kategori</div>
            </a>

            <a href="{{ route('owner.payment-methods.index', $outlet->id) }}"
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 text-center hover:shadow-md transition-shadow">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-credit-card text-xl"></i>
                </div>
                <div class="font-bold text-2xl text-slate-800">{{ $outlet->payment_methods_count ?? 0 }}</div>
                <div class="text-sm text-slate-500">Pembayaran</div>
            </a>

            <a href="{{ route('owner.discounts.index', $outlet->id) }}"
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 text-center hover:shadow-md transition-shadow">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-percent text-xl"></i>
                </div>
                <div class="font-bold text-2xl text-slate-800">{{ $outlet->discounts_count ?? 0 }}</div>
                <div class="text-sm text-slate-500">Diskon</div>
            </a>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-bolt text-amber-500"></i>
                Kelola Outlet
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('owner.products.create', $outlet->id) }}"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-plus-circle text-blue-500"></i>
                    <span class="font-medium text-slate-700">Tambah Produk</span>
                </a>
                <a href="{{ route('owner.categories.create', $outlet->id) }}"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-plus-circle text-green-500"></i>
                    <span class="font-medium text-slate-700">Tambah Kategori</span>
                </a>
                <a href="{{ route('owner.payment-methods.create', $outlet->id) }}"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-plus-circle text-purple-500"></i>
                    <span class="font-medium text-slate-700">Tambah Pembayaran</span>
                </a>
                <a href="{{ route('owner.discounts.create', $outlet->id) }}"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fas fa-plus-circle text-amber-500"></i>
                    <span class="font-medium text-slate-700">Tambah Diskon</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection