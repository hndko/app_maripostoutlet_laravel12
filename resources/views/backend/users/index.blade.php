@extends('layout.app-backend')

@section('title', 'Users')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Users</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">Daftar Users</h2>
    </div>
    <a href="{{ route('superadmin.users.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium bg-primary-600 text-white hover:bg-primary-700">
        <i class="fas fa-plus-circle"></i> Tambah User
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">User</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Dibuat</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-medium">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-medium text-slate-800">{{ $user->name }}</div>
                                @if($user->phone)<div class="text-xs text-slate-500">{{ $user->phone }}</div>@endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $user->email }}</td>
                    <td class="px-4 py-3.5">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $user->role == 'superadmin' ? 'bg-red-100 text-red-700' : ($user->role == 'owner' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-600') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3.5">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('superadmin.users.show', $user->id) }}"
                                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('superadmin.users.edit', $user->id) }}"
                                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('superadmin.users.toggle-active', $user->id) }}" method="POST"
                                class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100"
                                    title="Toggle Status">
                                    <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-slate-500">
                        <i class="fas fa-users text-4xl text-slate-300 mb-3"></i>
                        <p>Belum ada user</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection