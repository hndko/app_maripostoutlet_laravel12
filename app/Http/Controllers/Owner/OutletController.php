<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OutletController extends Controller
{
    /**
     * NOTE: Tampilkan daftar outlet milik owner
     */
    public function index()
    {
        $outlets = auth()->user()->outlets()
            ->withCount(['products', 'transactions'])
            ->get();

        $data = [
            'title' => 'Daftar Outlet',
            'outlets' => $outlets,
        ];

        return view('backend.outlets.index', $data);
    }

    /**
     * NOTE: Tampilkan form create outlet
     * - Cek limit outlet dari subscription
     */
    public function create()
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;

        // Cek limit outlet
        $currentCount = $user->outlets()->count();
        $maxOutlets = $subscription?->getLimit('outlets') ?? 1;

        if ($currentCount >= $maxOutlets) {
            return redirect()->route('owner.outlets.index')
                ->with('error', "Batas outlet tercapai ({$maxOutlets}). Upgrade paket untuk menambah outlet.");
        }

        $data = [
            'title' => 'Tambah Outlet',
        ];

        return view('backend.outlets.create', $data);
    }

    /**
     * NOTE: Simpan outlet baru
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;

        // Cek limit outlet
        $currentCount = $user->outlets()->count();
        $maxOutlets = $subscription?->getLimit('outlets') ?? 1;

        if ($currentCount >= $maxOutlets) {
            return back()->with('error', 'Batas outlet tercapai.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'owner_id' => $user->id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'is_active' => true,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('outlets', 'public');
        }

        $outlet = Outlet::create($data);

        UserActivityLog::logCreate('outlet', $outlet->toArray());

        return redirect()->route('owner.outlets.index')
            ->with('success', 'Outlet berhasil ditambahkan.');
    }

    /**
     * NOTE: Tampilkan detail outlet
     */
    public function show($id)
    {
        $outlet = $this->getOwnerOutlet($id);
        $outlet->loadCount(['products', 'categories', 'transactions', 'paymentMethods', 'discounts']);

        $data = [
            'title' => 'Detail Outlet: ' . $outlet->name,
            'outlet' => $outlet,
        ];

        return view('backend.outlets.show', $data);
    }

    /**
     * NOTE: Tampilkan form edit outlet
     */
    public function edit($id)
    {
        $outlet = $this->getOwnerOutlet($id);

        $data = [
            'title' => 'Edit Outlet: ' . $outlet->name,
            'outlet' => $outlet,
        ];

        return view('backend.outlets.edit', $data);
    }

    /**
     * NOTE: Update outlet
     */
    public function update(Request $request, $id)
    {
        $outlet = $this->getOwnerOutlet($id);
        $oldData = $outlet->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        if ($request->hasFile('logo')) {
            if ($outlet->logo && Storage::disk('public')->exists($outlet->logo)) {
                Storage::disk('public')->delete($outlet->logo);
            }
            $data['logo'] = $request->file('logo')->store('outlets', 'public');
        }

        $outlet->update($data);

        UserActivityLog::logUpdate('outlet', $oldData, $outlet->fresh()->toArray());

        return redirect()->route('owner.outlets.index')
            ->with('success', 'Outlet berhasil diupdate.');
    }

    /**
     * NOTE: Hapus outlet
     */
    public function destroy($id)
    {
        $outlet = $this->getOwnerOutlet($id);

        // Cek apakah ada transaksi
        if ($outlet->transactions()->exists()) {
            return back()->with('error', 'Outlet tidak dapat dihapus karena memiliki riwayat transaksi.');
        }

        $oldData = $outlet->toArray();

        if ($outlet->logo && Storage::disk('public')->exists($outlet->logo)) {
            Storage::disk('public')->delete($outlet->logo);
        }

        $outlet->delete();

        UserActivityLog::logDelete('outlet', $oldData);

        return redirect()->route('owner.outlets.index')
            ->with('success', 'Outlet berhasil dihapus.');
    }

    /**
     * NOTE: Toggle status aktif outlet
     */
    public function toggleActive($id)
    {
        $outlet = $this->getOwnerOutlet($id);
        $oldData = $outlet->toArray();

        $outlet->is_active = !$outlet->is_active;
        $outlet->save();

        UserActivityLog::logUpdate('outlet', $oldData, $outlet->fresh()->toArray());

        $status = $outlet->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Outlet berhasil {$status}.");
    }

    /**
     * NOTE: Helper untuk memastikan outlet milik owner yang login
     */
    private function getOwnerOutlet($id): Outlet
    {
        return Outlet::where('owner_id', auth()->id())->findOrFail($id);
    }
}
