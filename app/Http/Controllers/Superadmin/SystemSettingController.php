<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SystemSettingController extends Controller
{
    /**
     * NOTE: Tampilkan daftar setting groups
     */
    public function index()
    {
        $groups = SystemSetting::select('group')
            ->distinct()
            ->pluck('group');

        $data = [
            'title' => 'Pengaturan Sistem',
            'groups' => $groups,
            'settings' => SystemSetting::all()->groupBy('group'),
        ];

        return view('superadmin.settings.index', $data);
    }

    /**
     * NOTE: Tampilkan form edit settings per group
     */
    public function edit($group)
    {
        $settings = SystemSetting::where('group', $group)->get();

        if ($settings->isEmpty()) {
            abort(404);
        }

        $data = [
            'title' => 'Pengaturan ' . ucfirst($group),
            'group' => $group,
            'settings' => $settings,
        ];

        return view('superadmin.settings.edit', $data);
    }

    /**
     * NOTE: Update settings
     */
    public function update(Request $request, $group)
    {
        $settings = SystemSetting::where('group', $group)->get();

        if ($settings->isEmpty()) {
            abort(404);
        }

        $oldData = $settings->pluck('value', 'key')->toArray();

        foreach ($settings as $setting) {
            $key = $setting->key;

            if ($setting->type === 'image') {
                // Handle file upload
                if ($request->hasFile($key)) {
                    // Hapus file lama
                    if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }

                    $path = $request->file($key)->store('settings', 'public');
                    $setting->value = $path;
                    $setting->save();
                }
            } elseif ($setting->type === 'boolean') {
                $setting->value = $request->boolean($key) ? 'true' : 'false';
                $setting->save();
            } else {
                if ($request->has($key)) {
                    $setting->value = $request->input($key);
                    $setting->save();
                }
            }
        }

        $newData = SystemSetting::where('group', $group)
            ->get()
            ->pluck('value', 'key')
            ->toArray();

        // Log aktivitas
        UserActivityLog::logUpdate('system_settings_' . $group, $oldData, $newData);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
