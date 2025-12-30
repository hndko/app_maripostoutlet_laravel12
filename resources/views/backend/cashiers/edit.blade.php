@extends('layout.app-backend')

@section('title', 'Edit Kasir')

@section('sidebar')
@include('backend.partials.sidebar-owner')
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('owner.cashiers.index') }}">Kasir</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
        <h1 class="page-header mb-0">Edit Kasir: {{ $cashier->name }}</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('owner.cashiers.update', $cashier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', $cashier->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', $cashier->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone"
                                value="{{ old('phone', $cashier->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password Baru <span class="text-muted">(opsional)</span></label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label class="form-label">Avatar</label>
                    <div class="border rounded p-4 text-center mb-2" id="avatarPreview">
                        @if($cashier->avatar)
                        <img src="{{ Storage::url($cashier->avatar) }}" class="img-fluid rounded"
                            style="max-height: 150px">
                        @else
                        <i class="fa fa-user fa-3x text-muted"></i>
                        @endif
                    </div>
                    <input type="file" class="form-control" name="avatar" accept="image/*"
                        onchange="previewAvatar(this)">
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-theme"><i class="fa fa-save me-1"></i> Update</button>
                <a href="{{ route('owner.cashiers.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" style="max-height: 150px">';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush