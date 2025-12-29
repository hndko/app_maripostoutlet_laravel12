<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * NOTE: Tampilkan daftar semua subscription
     */
    public function index(Request $request)
    {
        $query = Subscription::with(['owner', 'package']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->whereHas('package', function ($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        $data = [
            'title' => 'Daftar Subscription',
            'subscriptions' => $query->orderBy('created_at', 'desc')->get(),
        ];

        return view('superadmin.subscriptions.index', $data);
    }

    /**
     * NOTE: Tampilkan detail subscription
     */
    public function show($id)
    {
        $subscription = Subscription::with(['owner', 'package', 'payments'])->findOrFail($id);

        $data = [
            'title' => 'Detail Subscription',
            'subscription' => $subscription,
        ];

        return view('superadmin.subscriptions.show', $data);
    }

    /**
     * NOTE: Form untuk membuat subscription lifetime (khusus superadmin)
     */
    public function createLifetime($owner_id)
    {
        $owner = User::where('role', 'owner')->findOrFail($owner_id);
        $lifetimePackage = SubscriptionPackage::where('type', 'lifetime')->where('is_active', true)->first();

        if (!$lifetimePackage) {
            return back()->with('error', 'Paket lifetime tidak tersedia.');
        }

        $data = [
            'title' => 'Buat Subscription Lifetime',
            'owner' => $owner,
            'package' => $lifetimePackage,
        ];

        return view('superadmin.subscriptions.create-lifetime', $data);
    }

    /**
     * NOTE: Simpan subscription lifetime
     */
    public function storeLifetime(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:subscription_packages,id',
            'notes' => 'nullable|string',
        ]);

        $owner = User::where('role', 'owner')->findOrFail($request->owner_id);
        $package = SubscriptionPackage::where('type', 'lifetime')->findOrFail($request->package_id);

        // Nonaktifkan subscription lama jika ada
        Subscription::where('owner_id', $owner->id)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        // Buat subscription baru
        $subscription = Subscription::create([
            'owner_id' => $owner->id,
            'package_id' => $package->id,
            'status' => 'active',
            'start_date' => now(),
            'end_date' => null, // Lifetime = no end date
            'auto_renew' => false,
        ]);

        // Log aktivitas
        UserActivityLog::logCreate('subscription_lifetime', array_merge(
            $subscription->toArray(),
            ['notes' => $request->notes]
        ));

        return redirect()->route('superadmin.subscriptions.index')
            ->with('success', "Subscription lifetime untuk {$owner->name} berhasil dibuat.");
    }
}
