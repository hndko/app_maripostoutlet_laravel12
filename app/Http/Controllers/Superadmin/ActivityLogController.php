<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * NOTE: Tampilkan daftar log aktivitas
     */
    public function index(Request $request)
    {
        $query = UserActivityLog::with('user');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by module
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $data = [
            'title' => 'Log Aktivitas',
            'logs' => $query->orderBy('created_at', 'desc')->get(),
            'actions' => UserActivityLog::select('action')->distinct()->pluck('action'),
            'modules' => UserActivityLog::select('module')->distinct()->pluck('module'),
        ];

        return view('superadmin.activity-logs.index', $data);
    }

    /**
     * NOTE: Tampilkan detail log
     */
    public function show($id)
    {
        $log = UserActivityLog::with('user')->findOrFail($id);

        $data = [
            'title' => 'Detail Log Aktivitas',
            'log' => $log,
        ];

        return view('superadmin.activity-logs.show', $data);
    }
}
