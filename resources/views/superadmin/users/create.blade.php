@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-superadmin')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-person-plus me-2"></i>Tambah User Baru
    </div>
    <div class="card-body">
        <form action="{{ route('superadmin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                            </div>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                            </div>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                            </div>
                            @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                                required>
                                <option value="">Pilih Role</option>
                                <option value="superadmin" {{ old('role')=='superadmin' ? 'selected' : '' }}>Superadmin
                                </option>
                                <option value="owner" {{ old('role')=='owner' ? 'selected' : '' }}>Owner</option>
                                <option value="kasir" {{ old('role')=='kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                            @error('role')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12" id="ownerField" style="display: none;">
                            <label for="owner_id" class="form-label">Pilih Owner <span
                                    class="text-danger">*</span></label>
                            <select class="form-select select2 @error('owner_id') is-invalid @enderror" id="owner_id"
                                name="owner_id">
                                <option value="">Pilih Owner</option>
                                @foreach(\App\Models\User::where('role', 'owner')->get() as $owner)
                                <option value="{{ $owner->id }}" {{ old('owner_id')==$owner->id ? 'selected' : '' }}>
                                    {{ $owner->name }} ({{ $owner->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('owner_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Minimal 6 karakter" required>
                            </div>
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Ulangi password" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Foto Profil</label>
                    <div class="image-preview mb-3" id="avatarPreview">
                        <i class="bi bi-person-circle text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar"
                        accept="image/*" onchange="previewImage(this, 'avatarPreview')">
                    @error('avatar')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan
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
        $('#owner_id').prop('required', true);
    } else {
        $('#ownerField').hide();
        $('#owner_id').prop('required', false);
    }
});

// Trigger on page load
$('#role').trigger('change');
</script>
@endpush