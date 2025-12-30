@extends('layout.app-backend')

@section('title', 'Kategori Produk')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('owner.outlets.show', $outlet->id) }}">{{ $outlet->name }}</a>
            </li>
            <li class="breadcrumb-item active">Kategori</li>
        </ol>
        <h1 class="page-header mb-0">Kategori Produk</h1>
    </div>
    <div class="ms-auto">
        <a href="{{ route('owner.categories.create', $outlet->id) }}" class="btn btn-theme">
            <i class="fa fa-plus-circle me-1"></i> Tambah Kategori
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="categoriesTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Produk</th>
                        <th>Status</th>
                        <th>Urutan</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                    <tr>
                        <td><strong>{{ $cat->name }}</strong></td>
                        <td>{{ $cat->products_count ?? 0 }}</td>
                        <td><span class="badge bg-{{ $cat->is_active ? 'success' : 'secondary' }}">{{ $cat->is_active ?
                                'Aktif' : 'Non-Aktif' }}</span></td>
                        <td>{{ $cat->sort_order }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('owner.categories.edit', [$outlet->id, $cat->id]) }}"
                                    class="btn btn-outline-primary"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('owner.categories.toggle-active', [$outlet->id, $cat->id]) }}"
                                    method="POST" class="d-inline">@csrf @method('PATCH')<button
                                        class="btn btn-outline-{{ $cat->is_active ? 'warning' : 'success' }}"><i
                                            class="fa fa-{{ $cat->is_active ? 'pause' : 'play' }}"></i></button></form>
                                <form action="{{ route('owner.categories.destroy', [$outlet->id, $cat->id]) }}"
                                    method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf
                                    @method('DELETE')<button class="btn btn-outline-danger"><i
                                            class="fa fa-trash"></i></button></form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection