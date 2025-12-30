@extends('layout.app-backend')

@section('title', 'Transaksi')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Transaksi</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">Riwayat Transaksi</h2>
    </div>
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
                <i class="fas fa-calendar mr-1 text-slate-400"></i> Tanggal
            </label>
            <input type="date" name="date" value="{{ request('date') }}"
                class="px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none">
        </div>
        <button type="submit"
            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
            <i class="fas fa-filter"></i> Filter
        </button>
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Invoice</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Outlet</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Kasir</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Total</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Waktu</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase w-24">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $trx->invoice_number }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $trx->outlet->name ?? '-' }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $trx->cashier->name ?? '-' }}</td>
                    <td class="px-4 py-3.5 text-right font-medium text-green-600">{{ formatRupiah($trx->total) }}</td>
                    <td class="px-4 py-3.5 text-center">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $trx->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $trx->payment_status == 'paid' ? 'Lunas' : 'Pending' }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-slate-500">{{ $trx->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-3.5 text-center">
                        <a href="{{ route('owner.transactions.show', $trx->id) }}"
                            class="p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-slate-500">
                        <i class="fas fa-receipt text-4xl text-slate-300 mb-3"></i>
                        <p>Belum ada transaksi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection