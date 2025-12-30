@extends('layout.app-backend')

@section('title', 'Kasir')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Kasir</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">Daftar Kasir</h2>
    </div>
    <a href="{{ route('owner.cashiers.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
        <i class="fas fa-plus-circle"></i> Tambah Kasir
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Kasir</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Phone</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cashiers as $cashier)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-medium">
                                {{ substr($cashier->name, 0, 1) }}
                            </div>
                            <span class="font-medium text-slate-800">{{ $cashier->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $cashier->email }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $cashier->phone ?? '-' }}</td>
                    <td class="px-4 py-3.5 text-center">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $cashier->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $cashier->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('owner.cashiers.edit', $cashier->id) }}"
                                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('owner.cashiers.toggle-active', $cashier->id) }}" method="POST"
                                class="inline">
                                @csrf @method('PATCH')
                                <button class="p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                                    <i class="fas fa-{{ $cashier->is_active ? 'ban' : 'check' }}"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center text-slate-500">
                        <i class="fas fa-user-tie text-4xl text-slate-300 mb-3"></i>
                        <p>Belum ada kasir</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection