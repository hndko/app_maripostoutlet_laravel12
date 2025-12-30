@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-person-badge me-2"></i>Daftar Kasir</span>
        <a href="{{ route('owner.cashiers.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>Tambah Kasir
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="cashiersTable">
                <thead>
                    <tr>
                        <th>Kasir</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cashiers as $cashier)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $cashier->avatar ? Storage::url($cashier->avatar) : asset('assets/backend/img/default-user.png') }}"
                                    alt="{{ $cashier->name }}" class="rounded-circle" width="40" height="40"
                                    style="object-fit: cover;">
                                <strong>{{ $cashier->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $cashier->email }}</td>
                        <td>{{ $cashier->phone ?? '-' }}</td>
                        <td>
                            @if($cashier->is_active)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td>{{ $cashier->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('owner.cashiers.edit', $cashier->id) }}"
                                    class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('owner.cashiers.toggle-active', $cashier->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn btn-outline-{{ $cashier->is_active ? 'warning' : 'success' }}">
                                        <i class="bi bi-{{ $cashier->is_active ? 'x-circle' : 'check-circle' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('owner.cashiers.destroy', $cashier->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kasir ini?')">
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
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    $('#cashiersTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
    });
});
</script>
@endpush