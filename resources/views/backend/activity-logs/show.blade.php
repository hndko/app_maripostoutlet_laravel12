@extends('layout.app-backend')

@section('title', 'Log Detail')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superadmin.activity-logs.index') }}">Activity Logs</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
        <h1 class="page-header mb-0">Log Detail</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-borderless">
            <tr>
                <th width="150">User</th>
                <td>{{ $log->user->name ?? 'System' }}</td>
            </tr>
            <tr>
                <th>Action</th>
                <td><span class="badge bg-info">{{ $log->action }}</span></td>
            </tr>
            <tr>
                <th>Module</th>
                <td>{{ $log->module }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $log->description }}</td>
            </tr>
            <tr>
                <th>IP Address</th>
                <td>{{ $log->ip_address }}</td>
            </tr>
            <tr>
                <th>User Agent</th>
                <td>{{ $log->user_agent }}</td>
            </tr>
            <tr>
                <th>Time</th>
                <td>{{ $log->created_at->format('d M Y H:i:s') }}</td>
            </tr>
        </table>

        @if($log->old_data || $log->new_data)
        <hr>
        <h5>Changes</h5>
        <div class="row">
            @if($log->old_data)
            <div class="col-md-6">
                <h6>Old Data</h6>
                <pre class="bg-light p-3 rounded">{{ json_encode($log->old_data, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
            @if($log->new_data)
            <div class="col-md-6">
                <h6>New Data</h6>
                <pre class="bg-light p-3 rounded">{{ json_encode($log->new_data, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
        </div>
        @endif
    </div>
    <div class="card-footer">
        <a href="{{ route('superadmin.activity-logs.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection