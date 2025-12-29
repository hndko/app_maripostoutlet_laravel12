<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CashierController extends Controller
{
    /**
     * NOTE: Tampilkan daftar kasir milik owner
     */
    public function index()
    {
        $cashiers = auth()->user()->cashiers()->get();

        $data = [
            'title' => 'Daftar Kasir',
            'cashiers' => $cashiers,
        ];

        return view('owner.cashiers.index', $data);
    }

    /**
     * NOTE: Tampilkan form create kasir
     * - Cek limit kasir dari subscription
     */
    public function create()
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;

        // Cek limit kasir
        $currentCount = $user->cashiers()->count();
        $maxCashiers = $subscription?->getLimit('cashiers') ?? 1;

        if ($currentCount >= $maxCashiers) {
            return redirect()->route('owner.cashiers.index')
                ->with('error', "Batas kasir tercapai ({$maxCashiers}). Upgrade paket untuk menambah kasir.");
        }

        $data = [
            'title' => 'Tambah Kasir',
        ];

        return view('owner.cashiers.create', $data);
    }

    /**
     * NOTE: Simpan kasir baru
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;

        // Cek limit kasir
        $currentCount = $user->cashiers()->count();
        $maxCashiers = $subscription?->getLimit('cashiers') ?? 1;

        if ($currentCount >= $maxCashiers) {
            return back()->with('error', 'Batas kasir tercapai.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $cashier = User::create([
            'owner_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'kasir',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        UserActivityLog::logCreate('cashier', $cashier->toArray());

        return redirect()->route('owner.cashiers.index')
            ->with('success', 'Kasir berhasil ditambahkan.');
    }

    /**
     * NOTE: Tampilkan form edit kasir
     */
    public function edit($id)
    {
        $cashier = $this->getOwnerCashier($id);

        $data = [
            'title' => 'Edit Kasir: ' . $cashier->name,
            'cashier' => $cashier,
        ];

        return view('owner.cashiers.edit', $data);
    }

    /**
     * NOTE: Update kasir
     */
    public function update(Request $request, $id)
    {
        $cashier = $this->getOwnerCashier($id);
        $oldData = $cashier->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $cashier->update($data);

        UserActivityLog::logUpdate('cashier', $oldData, $cashier->fresh()->toArray());

        return redirect()->route('owner.cashiers.index')
            ->with('success', 'Kasir berhasil diupdate.');
    }

    /**
     * NOTE: Hapus kasir
     */
    public function destroy($id)
    {
        $cashier = $this->getOwnerCashier($id);
        $oldData = $cashier->toArray();

        $cashier->delete();

        UserActivityLog::logDelete('cashier', $oldData);

        return redirect()->route('owner.cashiers.index')
            ->with('success', 'Kasir berhasil dihapus.');
    }

    /**
     * NOTE: Toggle status aktif kasir
     */
    public function toggleActive($id)
    {
        $cashier = $this->getOwnerCashier($id);
        $oldData = $cashier->toArray();

        $cashier->is_active = !$cashier->is_active;
        $cashier->save();

        UserActivityLog::logUpdate('cashier', $oldData, $cashier->fresh()->toArray());

        $status = $cashier->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Kasir berhasil {$status}.");
    }

    /**
     * NOTE: Helper untuk memastikan kasir milik owner yang login
     */
    private function getOwnerCashier($id): User
    {
        return User::where('owner_id', auth()->id())
            ->where('role', 'kasir')
            ->findOrFail($id);
    }
}
