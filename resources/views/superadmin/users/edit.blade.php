@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-superadmin')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-pencil me-2"></i>Edit User: {{ $user->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : ''
                                    }}>Superadmin</option>
                                <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner</option>
                                <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                        </div>

                        <div class="col-md-12" id="ownerField"
                            style="{{ $user->role == 'kasir' ? '' : 'display: none;' }}">
                            <label for="owner_id" class="form-label">Pilih Owner</label>
                            <select class="form-select select2" id="owner_id" name="owner_id">
                                <option value="">Pilih Owner</option>
                                @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ $user->owner_id == $owner->id ? 'selected' : '' }}>
                                    {{ $owner->name }} ({{ $owner->email }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <hr>
                            <p class="text-muted mb-2">Kosongkan jika tidak ingin mengubah password</p>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Minimal 6 karakter">
                            </div>
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Foto Profil</label>
                    <div class="image-preview mb-3" id="avatarPreview">
                        @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                        @else
                        <i class="bi bi-person-circle text-muted" style="font-size: 3rem;"></i>
                        @endif
                    </div>
                    <input type="file" class="form-control" name="avatar" accept="image/*"
                        onchange="previewImage(this, 'avatarPreview')">
                    <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Update
                </button>
                <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x me-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#role').on('change', function() {
    if (this.value === 'kasir') {
        $('#ownerField').show();
    } else {
        $('#ownerField').hide();
    }
});
</script>
@endpush