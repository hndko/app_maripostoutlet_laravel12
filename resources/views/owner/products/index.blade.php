@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span>
            <i class="bi bi-box-seam me-2"></i>Produk - {{ $outlet->name }}
        </span>
        <a href="{{ route('owner.products.create', $outlet->id) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>Tambah Produk
        </a>
    </div>
    <div class="card-body">
        {{-- Filters --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <select class="form-select select2" id="filterCategory">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Non-Aktif">Non-Aktif</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="productsTable">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $product->image ? Storage::url($product->image) : asset('assets/backend/img/default-product.png') }}"
                                    alt="{{ $product->name }}" class="rounded" width="50" height="50"
                                    style="object-fit: cover;">
                                <div>
                                    <strong>{{ $product->name }}</strong>
                                    @if($product->sku)
                                    <br><small class="text-muted">{{ $product->sku }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>{{ formatRupiah($product->price) }}</td>
                        <td>
                            @if($product->use_stock)
                            @if($product->isLowStock())
                            <span class="badge bg-danger">{{ $product->stock }}</span>
                            @else
                            <span class="badge bg-success">{{ $product->stock }}</span>
                            @endif
                            @else
                            <span class="text-muted">∞</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_active)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('owner.products.edit', [$outlet->id, $product->id]) }}"
                                    class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('owner.products.toggle-active', [$outlet->id, $product->id]) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn btn-outline-{{ $product->is_active ? 'warning' : 'success' }}">
                                        <i class="bi bi-{{ $product->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('owner.products.destroy', [$outlet->id, $product->id]) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('owner.outlets.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Outlet
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    var table = $('#productsTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
    });

    $('#filterCategory').on('change', function() {
        table.column(1).search(this.value).draw();
    });

    $('#filterStatus').on('change', function() {
        table.column(4).search(this.value).draw();
    });
});
</script>
@endpush