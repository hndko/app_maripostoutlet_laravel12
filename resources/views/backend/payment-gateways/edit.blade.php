@extends('layout.app-backend')

@section('title', 'Edit Payment Gateway')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superadmin.payment-gateways.index') }}">Payment Gateways</a>
            </li>
            <li class="breadcrumb-item active">{{ $gateway->name }}</li>
        </ol>
        <h1 class="page-header mb-0">Edit: {{ $gateway->name }}</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('superadmin.payment-gateways.update', $gateway->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" value="{{ $gateway->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mode</label>
                    <select class="form-select" name="is_sandbox">
                        <option value="1" {{ $gateway->is_sandbox ? 'selected' : '' }}>Sandbox</option>
                        <option value="0" {{ !$gateway->is_sandbox ? 'selected' : '' }}>Production</option>
                    </select>
                </div>

                @if($gateway->code == 'midtrans')
                <div class="col-md-6">
                    <label class="form-label">Server Key</label>
                    <input type="text" class="form-control" name="config[server_key]"
                        value="{{ $gateway->getConfig('server_key') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Client Key</label>
                    <input type="text" class="form-control" name="config[client_key]"
                        value="{{ $gateway->getConfig('client_key') }}">
                </div>
                @elseif($gateway->code == 'duitku')
                <div class="col-md-6">
                    <label class="form-label">Merchant Code</label>
                    <input type="text" class="form-control" name="config[merchant_code]"
                        value="{{ $gateway->getConfig('merchant_code') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">API Key</label>
                    <input type="text" class="form-control" name="config[api_key]"
                        value="{{ $gateway->getConfig('api_key') }}">
                </div>
                @endif
            </div>

            <hr>
            <button type="submit" class="btn btn-theme"><i class="fa fa-save me-1"></i> Simpan</button>
            <a href="{{ route('superadmin.payment-gateways.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection