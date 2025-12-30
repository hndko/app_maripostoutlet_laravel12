@extends('layout.app-backend')

@section('title', 'Laporan Penjualan')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
{{-- Report Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Laporan Penjualan</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">
            <i class="fas fa-chart-line text-primary-500 mr-2"></i>
            Laporan Penjualan
        </h2>
    </div>
    <button
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium border border-slate-300 text-slate-700 hover:bg-slate-50">
        <i class="fas fa-download"></i> Export
    </button>
</div>

{{-- Filter --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
    <form class="flex flex-wrap items-end gap-4" method="GET">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                <i class="fas fa-store mr-1 text-slate-400"></i> Outlet
            </label>
            <select name="outlet_id"
                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none">
                <option value="">Semua Outlet</option>
                @foreach($outlets ?? [] as $outlet)
                <option value="{{ $outlet->id }}" {{ request('outlet_id')==$outlet->id ? 'selected' : '' }}>{{
                    $outlet->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                <i class="fas fa-calendar mr-1 text-slate-400"></i> Dari
            </label>
            <input type="date" name="start_date"
                value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}"
                class="px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                <i class="fas fa-calendar mr-1 text-slate-400"></i> Sampai
            </label>
            <input type="date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}"
                class="px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none">
        </div>
        <button type="submit"
            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
            <i class="fas fa-filter"></i> Filter
        </button>
    </form>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-blue-100 text-sm mb-1">Total Transaksi</div>
                <div class="text-3xl font-bold">{{ $stats['total_transactions'] ?? 0 }}</div>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-receipt text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-green-100 text-sm mb-1">Total Pendapatan</div>
                <div class="text-3xl font-bold">{{ formatRupiah($stats['total_revenue'] ?? 0) }}</div>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-purple-100 text-sm mb-1">Rata-rata / Transaksi</div>
                <div class="text-3xl font-bold">{{ formatRupiah($stats['average'] ?? 0) }}</div>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-bar text-xl"></i>
            </div>
        </div>
    </div>
</div>

{{-- Chart Placeholder --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
    <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
        <i class="fas fa-chart-area text-primary-500"></i>
        Grafik Penjualan
    </h3>
    <div class="h-64 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400">
        <div class="text-center">
            <i class="fas fa-chart-line text-4xl mb-2"></i>
            <p>Chart akan muncul di sini</p>
        </div>
    </div>
</div>

{{-- Recent Transactions --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 font-semibold text-slate-700 flex items-center gap-2">
        <i class="fas fa-list text-primary-500"></i>
        Transaksi Terbaru
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Invoice</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Outlet</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions ?? [] as $trx)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $trx->invoice_number }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $trx->outlet->name ?? '-' }}</td>
                    <td class="px-4 py-3.5 font-medium text-green-600">{{ formatRupiah($trx->total) }}</td>
                    <td class="px-4 py-3.5 text-slate-500">{{ $trx->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection