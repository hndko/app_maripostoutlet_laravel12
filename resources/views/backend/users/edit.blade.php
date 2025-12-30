@extends('layout.app-backend')

@section('title', 'Edit User')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superadmin.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
        <h1 class="page-header mb-0">Edit User: {{ $user->name }}</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone"
                                value="{{ old('phone', $user->phone) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : ''
                                    }}>Superadmin</option>
                                <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Password Baru <span class="text-muted">(kosongkan jika tidak
                                    diubah)</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                        @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="img-fluid rounded"
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
                <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">Batal</a>
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