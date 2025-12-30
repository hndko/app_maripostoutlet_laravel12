@extends('layout.app-backend')

@section('title', 'Detail Transaksi')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="mb-6">
    <nav class="text-sm text-slate-500 mb-1">
        <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('owner.transactions.index') }}" class="hover:text-primary-600">Transaksi</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">{{ $transaction->invoice_number }}</span>
    </nav>
</div>

<div class="max-w-3xl">
    {{-- Invoice Header --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 mb-1">{{ $transaction->invoice_number }}</h2>
                <p class="text-slate-500">{{ $transaction->created_at->format('d F Y, H:i') }}</p>
            </div>
            <span
                class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $transaction->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                <i class="fas fa-{{ $transaction->payment_status == 'paid' ? 'check-circle' : 'clock' }} mr-1"></i>
                {{ $transaction->payment_status == 'paid' ? 'Lunas' : 'Pending' }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-slate-500">Outlet</span>
                <p class="font-medium text-slate-800">{{ $transaction->outlet->name ?? '-' }}</p>
            </div>
            <div>
                <span class="text-slate-500">Kasir</span>
                <p class="font-medium text-slate-800">{{ $transaction->cashier->name ?? '-' }}</p>
            </div>
            <div>
                <span class="text-slate-500">Metode Pembayaran</span>
                <p class="font-medium text-slate-800">{{ $transaction->paymentMethod->name ?? 'Cash' }}</p>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-200 font-semibold text-slate-700">
            <i class="fas fa-list mr-2 text-primary-500"></i>
            Item Pesanan
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Produk</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Qty</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Harga</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $item)
                <tr class="border-b border-slate-100">
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $item->product_name }}</td>
                    <td class="px-4 py-3.5 text-center text-slate-600">{{ $item->quantity }}</td>
                    <td class="px-4 py-3.5 text-right text-slate-600">{{ formatRupiah($item->price) }}</td>
                    <td class="px-4 py-3.5 text-right font-medium text-slate-800">{{ formatRupiah($item->subtotal) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="p-4 bg-slate-50 border-t border-slate-200">
            <div class="flex justify-between mb-2">
                <span class="text-slate-600">Subtotal</span>
                <span class="font-medium text-slate-800">{{ formatRupiah($transaction->subtotal) }}</span>
            </div>
            @if($transaction->discount_amount > 0)
            <div class="flex justify-between mb-2 text-green-600">
                <span>Diskon</span>
                <span>-{{ formatRupiah($transaction->discount_amount) }}</span>
            </div>
            @endif
            @if($transaction->tax_amount > 0)
            <div class="flex justify-between mb-2">
                <span class="text-slate-600">Pajak</span>
                <span class="font-medium text-slate-800">{{ formatRupiah($transaction->tax_amount) }}</span>
            </div>
            @endif
            <div class="flex justify-between pt-2 border-t border-slate-300">
                <span class="font-bold text-slate-800">Total</span>
                <span class="font-bold text-xl text-primary-600">{{ formatRupiah($transaction->total) }}</span>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex gap-3">
        <button onclick="window.print()"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
        <a href="{{ route('owner.transactions.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-slate-200 text-slate-700 hover:bg-slate-300">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection