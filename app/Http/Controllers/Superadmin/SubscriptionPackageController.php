<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;

class SubscriptionPackageController extends Controller
{
    /**
     * NOTE: Tampilkan daftar paket langganan
     */
    public function index()
    {
        $data = [
            'title' => 'Paket Langganan',
            'packages' => SubscriptionPackage::orderBy('sort_order')->get(),
        ];

        return view('backend.subscription-packages.index', $data);
    }

    /**
     * NOTE: Tampilkan form create paket
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Paket Langganan',
        ];

        return view('backend.subscription-packages.create', $data);
    }

    /**
     * NOTE: Simpan paket baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:trial,duration,lifetime',
            'duration_days' => 'required_if:type,trial,duration|nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'max_outlets' => 'required|integer|min:1',
            'max_cashiers' => 'required|integer|min:1',
            'max_products' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $data = $request->only([
            'name',
            'description',
            'type',
            'duration_days',
            'price',
            'max_outlets',
            'max_cashiers',
            'max_products',
            'sort_order'
        ]);

        $data['features'] = $request->features ?? [];
        $data['is_active'] = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured', false);

        // Lifetime tidak punya durasi
        if ($request->type === 'lifetime') {
            $data['duration_days'] = null;
        }

        $package = SubscriptionPackage::create($data);

        // Log aktivitas
        UserActivityLog::logCreate('subscription_package', $package->toArray());

        return redirect()->route('superadmin.subscription-packages.index')
            ->with('success', 'Paket berhasil ditambahkan.');
    }

    /**
     * NOTE: Tampilkan detail paket
     */
    public function show($id)
    {
        $package = SubscriptionPackage::withCount('subscriptions')->findOrFail($id);

        $data = [
            'title' => 'Detail Paket: ' . $package->name,
            'package' => $package,
        ];

        return view('backend.subscription-packages.show', $data);
    }

    /**
     * NOTE: Tampilkan form edit paket
     */
    public function edit($id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        $data = [
            'title' => 'Edit Paket: ' . $package->name,
            'package' => $package,
        ];

        return view('backend.subscription-packages.edit', $data);
    }

    /**
     * NOTE: Update paket
     */
    public function update(Request $request, $id)
    {
        $package = SubscriptionPackage::findOrFail($id);
        $oldData = $package->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:trial,duration,lifetime',
            'duration_days' => 'required_if:type,trial,duration|nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'max_outlets' => 'required|integer|min:1',
            'max_cashiers' => 'required|integer|min:1',
            'max_products' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $data = $request->only([
            'name',
            'description',
            'type',
            'duration_days',
            'price',
            'max_outlets',
            'max_cashiers',
            'max_products',
            'sort_order'
        ]);

        $data['features'] = $request->features ?? [];
        $data['is_active'] = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured', false);

        if ($request->type === 'lifetime') {
            $data['duration_days'] = null;
        }

        $package->update($data);

        // Log aktivitas
        UserActivityLog::logUpdate('subscription_package', $oldData, $package->fresh()->toArray());

        return redirect()->route('superadmin.subscription-packages.index')
            ->with('success', 'Paket berhasil diupdate.');
    }

    /**
     * NOTE: Hapus paket
     */
    public function destroy($id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        // Cek apakah ada subscription yang menggunakan paket ini
        if ($package->subscriptions()->exists()) {
            return back()->with('error', 'Paket tidak dapat dihapus karena masih digunakan.');
        }

        $oldData = $package->toArray();
        $package->delete();

        // Log aktivitas
        UserActivityLog::logDelete('subscription_package', $oldData);

        return redirect()->route('superadmin.subscription-packages.index')
            ->with('success', 'Paket berhasil dihapus.');
    }

    /**
     * NOTE: Toggle status aktif paket
     */
    public function toggleActive($id)
    {
        $package = SubscriptionPackage::findOrFail($id);
        $oldData = $package->toArray();

        $package->is_active = !$package->is_active;
        $package->save();

        // Log aktivitas
        UserActivityLog::logUpdate('subscription_package', $oldData, $package->fresh()->toArray());

        $status = $package->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Paket berhasil {$status}.");
    }
}
