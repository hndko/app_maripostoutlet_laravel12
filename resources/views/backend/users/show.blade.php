@extends('layout.app-backend')

@section('title', 'Detail User')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superadmin.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active">{{ $user->name }}</li>
        </ol>
        <h1 class="page-header mb-0">{{ $user->name }}</h1>
    </div>
    <div class="ms-auto">
        <a href="{{ route('superadmin.users.edit', $user->id) }}" class="btn btn-primary">
            <i class="fa fa-edit me-1"></i> Edit
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('assets/backend/img/user/user.jpg') }}"
                    alt="" class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover">
                <h4>{{ $user->name }}</h4>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <span
                    class="badge bg-{{ $user->role == 'superadmin' ? 'danger' : ($user->role == 'owner' ? 'primary' : 'secondary') }} mb-2">
                    {{ ucfirst($user->role) }}
                </span>
                @if($user->is_active)
                <span class="badge bg-success">Aktif</span>
                @else
                <span class="badge bg-secondary">Non-Aktif</span>
                @endif
            </div>
            <div class="card-footer">
                <small class="text-muted">Joined: {{ $user->created_at->format('d M Y') }}</small>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><i class="fa fa-info-circle me-2"></i>Informasi</div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="150">Phone</th>
                        <td>{{ $user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email Verified</th>
                        <td>{{ $user->email_verified_at ? $user->email_verified_at->format('d M Y H:i') : 'Belum' }}
                        </td>
                    </tr>
                    <tr>
                        <th>SSO Provider</th>
                        <td>{{ $user->sso_provider ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($user->role == 'owner')
        <div class="card mb-3">
            <div class="card-header"><i class="fa fa-store me-2"></i>Outlets ({{ $user->outlets->count() }})</div>
            <div class="card-body">
                @if($user->outlets->count())
                <ul class="list-group list-group-flush">
                    @foreach($user->outlets as $outlet)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $outlet->name }}
                        <span class="badge bg-{{ $outlet->is_active ? 'success' : 'secondary' }}">{{ $outlet->is_active
                            ? 'Aktif' : 'Non-Aktif' }}</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted mb-0">Belum ada outlet</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="fa fa-crown me-2"></i>Subscription</div>
            <div class="card-body">
                @if($user->activeSubscription)
                @php $sub = $user->activeSubscription; @endphp
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="150">Package</th>
                        <td>{{ $sub->package->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="badge bg-success">{{ ucfirst($sub->status) }}</span></td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>{{ $sub->end_date ? $sub->end_date->format('d M Y') : 'Lifetime' }}</td>
                    </tr>
                </table>
                @else
                <p class="text-muted mb-0">Tidak ada subscription aktif</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection