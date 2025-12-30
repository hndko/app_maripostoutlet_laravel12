@extends('layout.app-backend')

@section('title', 'Payment Gateways')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Payment Gateways</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">Payment Gateways</h2>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($gateways as $gateway)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-credit-card text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-lg text-slate-800">{{ $gateway->name }}</h3>
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $gateway->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $gateway->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if($gateway->is_sandbox)
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-700">Sandbox</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <p class="text-slate-500 text-sm mb-4">{{ $gateway->description ?? 'No description' }}</p>
        <div class="flex gap-2">
            <a href="{{ route('superadmin.payment-gateways.edit', $gateway->id) }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm border border-slate-300 text-slate-600 hover:bg-slate-50">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('superadmin.payment-gateways.toggle-active', $gateway->id) }}" method="POST">
                @csrf @method('PATCH')
                <button
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm border border-slate-300 text-slate-600 hover:bg-slate-50">
                    <i class="fas fa-{{ $gateway->is_active ? 'pause' : 'play' }}"></i> {{ $gateway->is_active ?
                    'Disable' : 'Enable' }}
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection