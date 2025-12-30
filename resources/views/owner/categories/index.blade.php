@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-tags me-2"></i>Kategori - {{ $outlet->name }}</span>
        <a href="{{ route('owner.categories.create', $outlet->id) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>Tambah Kategori
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="categoriesTable">
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Kategori</th>
                        <th>Jumlah Produk</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $category->image ? Storage::url($category->image) : asset('assets/backend/img/default-product.png') }}"
                                    alt="{{ $category->name }}" class="rounded" width="40" height="40"
                                    style="object-fit: cover;">
                                <strong>{{ $category->name }}</strong>
                            </div>
                        </td>
                        <td><span class="badge bg-info">{{ $category->products_count }}</span></td>
                        <td>
                            @if($category->is_active)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('owner.categories.edit', [$outlet->id, $category->id]) }}"
                                    class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form
                                    action="{{ route('owner.categories.toggle-active', [$outlet->id, $category->id]) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn btn-outline-{{ $category->is_active ? 'warning' : 'success' }}">
                                        <i class="bi bi-{{ $category->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('owner.categories.destroy', [$outlet->id, $category->id]) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
        <a href="{{ route('owner.outlets.show', $outlet->id) }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Outlet
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    $('#categoriesTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
    });
});
</script>
@endpush