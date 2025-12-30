@extends('layout.app-backend')

@section('title', 'Tambah Produk')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="mb-6">
    <nav class="text-sm text-slate-500 mb-1">
        <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('owner.products.index', $outlet->id) }}" class="hover:text-primary-600">Produk</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Tambah</span>
    </nav>
    <h2 class="text-xl font-bold text-slate-800">Tambah Produk Baru</h2>
</div>

<form action="{{ route('owner.products.store', $outlet->id) }}" method="POST" enctype="multipart/form-data"
    class="max-w-3xl">
    @csrf

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-box text-primary-500"></i>
            Informasi Produk
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-tag mr-1 text-slate-400"></i> Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-barcode mr-1 text-slate-400"></i> SKU
                </label>
                <input type="text" name="sku" value="{{ old('sku') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-folder mr-1 text-slate-400"></i> Kategori
                </label>
                <select name="category_id"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-money-bill mr-1 text-slate-400"></i> Harga Jual <span class="text-red-500">*</span>
                </label>
                <input type="number" name="price" value="{{ old('price') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none"
                    required min="0">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-coins mr-1 text-slate-400"></i> Harga Modal
                </label>
                <input type="number" name="cost_price" value="{{ old('cost_price') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none"
                    min="0">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-image mr-1 text-slate-400"></i> Gambar Produk
                </label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-primary-600 file:text-white">
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer mt-6">
                    <input type="checkbox" name="use_stock" value="1"
                        class="w-4 h-4 rounded border-slate-300 text-primary-600">
                    <span class="text-sm text-slate-700"><i class="fas fa-cubes mr-1 text-slate-400"></i> Kelola
                        Stok</span>
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-align-left mr-1 text-slate-400"></i> Deskripsi
                </label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none">{{ old('description') }}</textarea>
            </div>
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit"
            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="{{ route('owner.products.index', $outlet->id) }}"
            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-slate-200 text-slate-700 hover:bg-slate-300">
            <i class="fas fa-times"></i> Batal
        </a>
    </div>
</form>
@endsection