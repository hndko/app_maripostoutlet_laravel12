@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-superadmin')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-people me-2"></i>Master Users</span>
        <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>Tambah User
        </a>
    </div>
    <div class="card-body">
        {{-- Filters --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <select class="form-select select2" id="filterRole">
                    <option value="">Semua Role</option>
                    <option value="superadmin">Superadmin</option>
                    <option value="owner">Owner</option>
                    <option value="kasir">Kasir</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select select2" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Non-Aktif</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="usersTable">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('assets/backend/img/default-user.png') }}"
                                    alt="{{ $user->name }}" class="rounded-circle" width="40" height="40"
                                    style="object-fit: cover;">
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->phone)
                                    <br><small class="text-muted">{{ $user->phone }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @switch($user->role)
                            @case('superadmin')
                            <span class="badge bg-danger">Superadmin</span>
                            @break
                            @case('owner')
                            <span class="badge bg-primary">Owner</span>
                            @break
                            @case('kasir')
                            <span class="badge bg-info">Kasir</span>
                            @break
                            @endswitch
                        </td>
                        <td>
                            @if($user->is_active)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('superadmin.users.show', $user->id) }}" class="btn btn-outline-info"
                                    title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('superadmin.users.edit', $user->id) }}"
                                    class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('superadmin.users.toggle-active', $user->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn btn-outline-{{ $user->is_active ? 'warning' : 'success' }}"
                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="bi bi-{{ $user->is_active ? 'x-circle' : 'check-circle' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
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

@push('scripts')
<script>
    $(document).ready(function() {
    var table = $('#usersTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });

    // Filter by role
    $('#filterRole').on('change', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by status
    $('#filterStatus').on('change', function() {
        var val = this.value === 'active' ? 'Aktif' : (this.value === 'inactive' ? 'Non-Aktif' : '');
        table.column(3).search(val).draw();
    });
});
</script>
@endpush