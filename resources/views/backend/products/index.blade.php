@extends('layout.app-backend')

@section('title', 'Produk')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <a href="{{ route('owner.outlets.show', $outlet->id) }}" class="hover:text-primary-600">{{ $outlet->name
                }}</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Produk</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">Produk</h2>
    </div>
    <a href="{{ route('owner.products.create', $outlet->id) }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
        <i class="fas fa-plus-circle"></i> Tambah Produk
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Produk</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">SKU</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Kategori</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Harga</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Stok</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center">
                                @if($product->image)
                                <img src="{{ Storage::url($product->image) }}"
                                    class="w-12 h-12 rounded-lg object-cover">
                                @else
                                <i class="fas fa-box text-slate-400"></i>
                                @endif
                            </div>
                            <span class="font-medium text-slate-800">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600 font-mono text-xs">{{ $product->sku ?? '-' }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-4 py-3.5 text-right font-medium text-primary-600">{{ formatRupiah($product->price) }}
                    </td>
                    <td class="px-4 py-3.5 text-center">
                        @if($product->use_stock)
                        <span class="{{ $product->isLowStock() ? 'text-red-600' : 'text-slate-800' }}">{{
                            $product->stock }}</span>
                        @else
                        <span class="text-slate-400">∞</span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-center">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $product->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('owner.products.edit', [$outlet->id, $product->id]) }}"
                                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('owner.products.toggle-active', [$outlet->id, $product->id]) }}"
                                method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button class="p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                                    <i class="fas fa-{{ $product->is_active ? 'ban' : 'check' }}"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-slate-500">
                        <i class="fas fa-box text-4xl text-slate-300 mb-3"></i>
                        <p>Belum ada produk</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection