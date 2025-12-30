@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-superadmin')
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('assets/backend/img/default-user.png') }}"
                    alt="{{ $user->name }}" class="rounded-circle mb-3" width="120" height="120"
                    style="object-fit: cover;">
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-2">{{ $user->email }}</p>
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
                @if($user->is_active)
                <span class="badge bg-success">Aktif</span>
                @else
                <span class="badge bg-secondary">Non-Aktif</span>
                @endif
            </div>
            <hr class="my-0">
            <div class="card-body">
                <p class="mb-1"><i class="bi bi-phone me-2"></i>{{ $user->phone ?? '-' }}</p>
                <p class="mb-1"><i class="bi bi-calendar me-2"></i>Bergabung: {{ $user->created_at->format('d M Y') }}
                </p>
                @if($user->isCashier() && $user->owner)
                <p class="mb-1"><i class="bi bi-person me-2"></i>Owner: {{ $user->owner->name }}</p>
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex gap-2">
                    <a href="{{ route('superadmin.users.edit', $user->id) }}" class="btn btn-primary btn-sm flex-fill">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        @if($user->isOwner())
        {{-- Owner Info --}}
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-shop me-2"></i>Outlet ({{ $user->outlets->count() }})</div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($user->outlets as $outlet)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $outlet->name }}</strong>
                            <br><small class="text-muted">{{ $outlet->address }}</small>
                        </div>
                        <span class="badge bg-{{ $outlet->is_active ? 'success' : 'secondary' }}">
                            {{ $outlet->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>
                    @empty
                    <div class="list-group-item text-muted">Belum ada outlet</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-person-badge me-2"></i>Kasir ({{ $user->cashiers->count() }})</div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($user->cashiers as $cashier)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $cashier->name }}</strong>
                            <br><small class="text-muted">{{ $cashier->email }}</small>
                        </div>
                        <span class="badge bg-{{ $cashier->is_active ? 'success' : 'secondary' }}">
                            {{ $cashier->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>
                    @empty
                    <div class="list-group-item text-muted">Belum ada kasir</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="bi bi-star me-2"></i>Riwayat Subscription</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Paket</th>
                                <th>Status</th>
                                <th>Mulai</th>
                                <th>Berakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->subscriptions as $sub)
                            <tr>
                                <td>{{ $sub->package->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $sub->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($sub->status) }}
                                    </span>
                                </td>
                                <td>{{ $sub->start_date->format('d/m/Y') }}</td>
                                <td>{{ $sub->end_date ? $sub->end_date->format('d/m/Y') : 'Selamanya' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-muted text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection