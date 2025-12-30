@extends('layout.app-backend')

@section('title', 'Tambah User')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="mb-6">
    <nav class="text-sm text-slate-500 mb-1">
        <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('superadmin.users.index') }}" class="hover:text-primary-600">Users</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Tambah</span>
    </nav>
    <h2 class="text-xl font-bold text-slate-800">Tambah User Baru</h2>
</div>

<form action="{{ route('superadmin.users.store') }}" method="POST" enctype="multipart/form-data" class="max-w-3xl">
    @csrf

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-user text-primary-500"></i>
            Informasi User
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-user mr-1 text-slate-400"></i> Nama <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none @error('name') border-red-500 @enderror"
                    required>
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-envelope mr-1 text-slate-400"></i> Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none @error('email') border-red-500 @enderror"
                    required>
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-phone mr-1 text-slate-400"></i> Phone
                </label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-user-tag mr-1 text-slate-400"></i> Role <span class="text-red-500">*</span>
                </label>
                <select name="role"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none"
                    required>
                    <option value="">Pilih Role</option>
                    <option value="superadmin" {{ old('role')=='superadmin' ? 'selected' : '' }}>Superadmin</option>
                    <option value="owner" {{ old('role')=='owner' ? 'selected' : '' }}>Owner</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-lock mr-1 text-slate-400"></i> Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none @error('password') border-red-500 @enderror"
                    required>
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <i class="fas fa-lock mr-1 text-slate-400"></i> Konfirmasi Password <span
                        class="text-red-500">*</span>
                </label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none"
                    required>
            </div>
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit"
            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="{{ route('superadmin.users.index') }}"
            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium bg-slate-200 text-slate-700 hover:bg-slate-300">
            <i class="fas fa-times"></i> Batal
        </a>
    </div>
</form>
@endsection