@extends('layout.app-backend')

@section('title', 'Subscription Packages')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Packages</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">Subscription Packages</h2>
    </div>
    <a href="{{ route('superadmin.subscription-packages.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
        <i class="fas fa-plus-circle"></i> Tambah Package
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($packages as $pkg)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-bold text-xl text-slate-800">{{ $pkg->name }}</h3>
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary-100 text-primary-700">{{
                        ucfirst($pkg->type) }}</span>
                </div>
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $pkg->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $pkg->is_active ? 'Aktif' : 'Non-Aktif' }}
                </span>
            </div>
            <div class="text-3xl font-bold text-primary-600 mb-2">{{ formatRupiah($pkg->price) }}</div>
            <div class="text-slate-500 text-sm">{{ $pkg->duration_days ? $pkg->duration_days.' hari' : 'Lifetime' }}
            </div>
        </div>
        <div class="p-4 bg-slate-50 flex gap-2">
            <a href="{{ route('superadmin.subscription-packages.edit', $pkg->id) }}"
                class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm border border-slate-300 text-slate-600 hover:bg-slate-100">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('superadmin.subscription-packages.toggle-active', $pkg->id) }}" method="POST"
                class="flex-1">
                @csrf @method('PATCH')
                <button
                    class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm border border-slate-300 text-slate-600 hover:bg-slate-100">
                    <i class="fas fa-{{ $pkg->is_active ? 'pause' : 'play' }}"></i> {{ $pkg->is_active ? 'Disable' :
                    'Enable' }}
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection