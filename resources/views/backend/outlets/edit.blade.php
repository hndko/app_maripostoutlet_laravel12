@extends('layout.app-backend')

@section('title', 'Edit Outlet')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="mb-6">
    <nav class="text-sm text-slate-500 mb-1">
        <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('owner.outlets.index') }}" class="hover:text-primary-600">Outlets</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Edit</span>
    </nav>
    <h2 class="text-xl font-bold text-slate-800">Edit: {{ $outlet->name }}</h2>
</div>

<form action="{{ route('owner.outlets.update', $outlet->id) }}" method="POST" enctype="multipart/form-data"
    class="max-w-3xl">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-store text-primary-500"></i>
            Informasi Outlet
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-signature mr-1 text-slate-400"></i> Nama Outlet <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $outlet->name) }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-phone mr-1 text-slate-400"></i> No. Telepon
                </label>
                <input type="tel" name="phone" value="{{ old('phone', $outlet->phone) }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-image mr-1 text-slate-400"></i> Logo Baru
                </label>
                <input type="file" name="logo" accept="image/*"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-primary-600 file:text-white">
                @if($outlet->logo)
                <p class="text-xs text-slate-500 mt-1">Logo saat ini tersimpan</p>
                @endif
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-map-marker-alt mr-1 text-slate-400"></i> Alamat
                </label>
                <textarea name="address" rows="3"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all">{{ old('address', $outlet->address) }}</textarea>
            </div>
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit"
            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700 transition-all">
            <i class="fas fa-save"></i> Update
        </button>
        <a href="{{ route('owner.outlets.index') }}"
            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-slate-200 text-slate-700 hover:bg-slate-300 transition-all">
            <i class="fas fa-times"></i> Batal
        </a>
    </div>
</form>
@endsection