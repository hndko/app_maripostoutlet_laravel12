@extends('layout.app-backend')

@section('title', 'Subscription Payments')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Payments</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">Subscription Payments</h2>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Invoice</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Owner</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Amount</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Method</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $payment->invoice_number }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $payment->subscription->owner->name ?? '-' }}</td>
                    <td class="px-4 py-3.5 text-right font-medium text-primary-600">{{ formatRupiah($payment->amount) }}
                    </td>
                    <td class="px-4 py-3.5 text-center text-slate-600">{{ ucfirst($payment->payment_method) }}</td>
                    <td class="px-4 py-3.5 text-center">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $payment->status == 'paid' ? 'bg-green-100 text-green-700' : ($payment->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-slate-500">{{ $payment->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3.5">
                        @if($payment->status == 'pending')
                        <div class="flex items-center justify-center gap-1">
                            <form action="{{ route('superadmin.subscription-payments.approve', $payment->id) }}"
                                method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button class="p-2 rounded-lg text-green-600 hover:bg-green-50" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('superadmin.subscription-payments.reject', $payment->id) }}"
                                method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button class="p-2 rounded-lg text-red-600 hover:bg-red-50" title="Reject">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        @else
                        <span class="text-slate-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-slate-500">Belum ada payment</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection