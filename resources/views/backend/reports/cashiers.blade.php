@extends('layout.app-backend')

@section('title', 'Laporan Kasir')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Laporan Kasir</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">
            <i class="fas fa-user-tie text-primary-500 mr-2"></i>
            Laporan Kasir
        </h2>
    </div>
    <button
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium border border-slate-300 text-slate-700 hover:bg-slate-50">
        <i class="fas fa-download"></i> Export
    </button>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 font-semibold text-slate-700 flex items-center gap-2">
        <i class="fas fa-list text-primary-500"></i>
        Performa Kasir
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Kasir</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Total Transaksi
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cashiers ?? [] as $cashier)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white">
                                {{ substr($cashier->name, 0, 1) }}
                            </div>
                            <span class="font-medium text-slate-800">{{ $cashier->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-center font-medium text-slate-800">{{ $cashier->transactions_count ?? 0
                        }}</td>
                    <td class="px-4 py-3.5 text-right font-medium text-green-600">{{ formatRupiah($cashier->total_sales
                        ?? 0) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-8 text-center text-slate-500">Belum ada data kasir</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection