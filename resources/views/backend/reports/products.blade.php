@extends('layout.app-backend')

@section('title', 'Laporan Produk')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Laporan Produk</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">
            <i class="fas fa-chart-bar text-primary-500 mr-2"></i>
            Laporan Produk
        </h2>
    </div>
    <button
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium border border-slate-300 text-slate-700 hover:bg-slate-50">
        <i class="fas fa-download"></i> Export
    </button>
</div>

{{-- Stats --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-box"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-800">{{ $stats['total_products'] ?? 0 }}</div>
                <div class="text-sm text-slate-500">Total Produk</div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-800">{{ $stats['total_sold'] ?? 0 }}</div>
                <div class="text-sm text-slate-500">Terjual</div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-star"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-800">{{ $stats['best_seller'] ?? '-' }}</div>
                <div class="text-sm text-slate-500">Best Seller</div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-800">{{ $stats['low_stock'] ?? 0 }}</div>
                <div class="text-sm text-slate-500">Stok Rendah</div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 font-semibold text-slate-700 flex items-center gap-2">
        <i class="fas fa-list text-primary-500"></i>
        Performa Produk
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Produk</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Outlet</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Terjual</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products ?? [] as $product)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-slate-400"></i>
                            </div>
                            <span class="font-medium text-slate-800">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $product->outlet->name ?? '-' }}</td>
                    <td class="px-4 py-3.5 text-center font-medium text-slate-800">{{ $product->sold_count ?? 0 }}</td>
                    <td class="px-4 py-3.5 text-right font-medium text-green-600">{{ formatRupiah($product->revenue ??
                        0) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection