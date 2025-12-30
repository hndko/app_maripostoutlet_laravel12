@extends('layout.app-backend')

@section('title', 'Activity Logs')

@section('sidebar')
@include('backend.partials.sidebar-superadmin')
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Activity Logs</span>
        </nav>
        <h2 class="text-xl font-bold text-slate-800">Activity Logs</h2>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">User</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Action</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Module</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Description</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Time</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase w-20">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $log->user->name ?? 'System' }}</td>
                    <td class="px-4 py-3.5 text-center">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $log->action == 'create' ? 'bg-green-100 text-green-700' : ($log->action == 'delete' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $log->module }}</td>
                    <td class="px-4 py-3.5 text-slate-600">{{ Str::limit($log->description, 40) }}</td>
                    <td class="px-4 py-3.5 text-slate-500">{{ $log->created_at->diffForHumans() }}</td>
                    <td class="px-4 py-3.5 text-center">
                        <a href="{{ route('superadmin.activity-logs.show', $log->id) }}"
                            class="p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-slate-500">Belum ada activity</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection