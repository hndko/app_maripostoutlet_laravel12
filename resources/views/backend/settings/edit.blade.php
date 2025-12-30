@extends('layout.app-backend')

@section('title', 'Edit Settings')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superadmin.settings.index') }}">Settings</a></li>
            <li class="breadcrumb-item active">{{ ucwords(str_replace('_', ' ', $group)) }}</li>
        </ol>
        <h1 class="page-header mb-0">Edit: {{ ucwords(str_replace('_', ' ', $group)) }}</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('superadmin.settings.update', $group) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            @foreach($settings ?? [] as $setting)
            <div class="mb-3">
                <label class="form-label">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>
                @if($setting->type == 'boolean')
                <select class="form-select" name="settings[{{ $setting->key }}]">
                    <option value="1" {{ $setting->value ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ !$setting->value ? 'selected' : '' }}>Tidak</option>
                </select>
                @elseif($setting->type == 'textarea')
                <textarea class="form-control" name="settings[{{ $setting->key }}]"
                    rows="3">{{ $setting->value }}</textarea>
                @else
                <input type="{{ $setting->type == 'number' ? 'number' : 'text' }}" class="form-control"
                    name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">
                @endif
            </div>
            @endforeach

            <hr>
            <button type="submit" class="btn btn-theme"><i class="fa fa-save me-1"></i> Simpan</button>
            <a href="{{ route('superadmin.settings.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection