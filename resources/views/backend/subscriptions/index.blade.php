@extends('layout.app-backend')

@section('title', 'Subscriptions')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Subscriptions</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">Daftar Subscriptions</h2>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Owner</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Package</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Mulai</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Berakhir</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase w-24">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $sub)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $sub->owner->name ?? '-' }}</td>
                    <td class="px-4 py-3.5">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-700">
                            {{ $sub->package->name ?? '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-center">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $sub->status == 'active' ? 'bg-green-100 text-green-700' : ($sub->status == 'expired' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $sub->start_date?->format('d M Y') ?? '-' }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $sub->end_date?->format('d M Y') ?? 'Lifetime' }}</td>
                    <td class="px-4 py-3.5 text-center">
                        <a href="{{ route('superadmin.subscriptions.show', $sub->id) }}"
                            class="p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-slate-500">Belum ada subscription</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection