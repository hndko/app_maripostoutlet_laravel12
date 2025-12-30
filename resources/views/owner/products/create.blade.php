@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2"></i>Tambah Produk - {{ $outlet->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('owner.products.store', $outlet->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-box"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Nama produk" required>
                            </div>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="sku" class="form-label">SKU / Kode</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-upc"></i></span>
                                <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku') }}"
                                    placeholder="Opsional">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Kategori <span
                                    class="text-danger">*</span></label>
                            <select class="form-select select2 @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label">Harga Jual <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price') }}" placeholder="0" min="0" required>
                            </div>
                            @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="cost_price" class="form-label">Harga Modal</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="cost_price" name="cost_price"
                                    value="{{ old('cost_price') }}" placeholder="0" min="0">
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                placeholder="Deskripsi produk (opsional)">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-12">
                            <hr>
                            <h6><i class="bi bi-boxes me-2"></i>Pengaturan Stok</h6>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="use_stock" name="use_stock"
                                    value="1" {{ old('use_stock') ? 'checked' : '' }}>
                                <label class="form-check-label" for="use_stock">Gunakan Stok</label>
                            </div>
                        </div>

                        <div class="col-md-4 stock-field" style="{{ old('use_stock') ? '' : 'display: none;' }}">
                            <label for="stock" class="form-label">Stok Awal</label>
                            <input type="number" class="form-control" id="stock" name="stock"
                                value="{{ old('stock', 0) }}" min="0">
                        </div>

                        <div class="col-md-4 stock-field" style="{{ old('use_stock') ? '' : 'display: none;' }}">
                            <label for="min_stock" class="form-label">Stok Minimum</label>
                            <input type="number" class="form-control" id="min_stock" name="min_stock"
                                value="{{ old('min_stock', 5) }}" min="0">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Foto Produk</label>
                    <div class="image-preview mb-3" id="imagePreview">
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <input type="file" class="form-control" name="image" accept="image/*"
                        onchange="previewImage(this, 'imagePreview')">
                    <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
                <a href="{{ route('owner.products.index', $outlet->id) }}" class="btn btn-secondary">
                    <i class="bi bi-x me-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#use_stock').on('change', function() {
    if (this.checked) {
        $('.stock-field').show();
    } else {
        $('.stock-field').hide();
    }
});
</script>
@endpush