@extends('layout.app-backend')

@section('title', 'Settings')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Settings</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">System Settings</h2>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($groups ?? [] as $group => $settings)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h3 class="font-semibold text-slate-800">{{ ucwords(str_replace('_', ' ', $group)) }}</h3>
                <p class="text-sm text-slate-500">{{ count($settings) }} pengaturan</p>
            </div>
            <div class="w-10 h-10 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-cog"></i>
            </div>
        </div>
        <a href="{{ route('superadmin.settings.edit', $group) }}"
            class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 text-sm font-medium">
            <i class="fas fa-edit"></i> Edit Settings
        </a>
    </div>
    @endforeach
</div>
@endsection