<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * NOTE: Tampilkan daftar semua users dengan filter
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $data = [
            'title' => 'Master Users',
            'users' => $query->orderBy('created_at', 'desc')->get(),
        ];

        return view('backend.users.index', $data);
    }

    /**
     * NOTE: Tampilkan form create user
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah User',
        ];

        return view('backend.users.create', $data);
    }

    /**
     * NOTE: Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:superadmin,owner,kasir',
            'owner_id' => 'required_if:role,kasir|nullable|exists:users,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'owner_id' => $request->role === 'kasir' ? $request->owner_id : null,
            'is_active' => true,
            'email_verified_at' => now(),
        ];

        // Upload avatar
        if ($request->hasFile('avatar')) {
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($userData);

        // Log aktivitas
        UserActivityLog::logCreate('user', $user->toArray());

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * NOTE: Tampilkan detail user
     */
    public function show($id)
    {
        $user = User::with(['owner', 'cashiers', 'outlets', 'subscriptions.package'])->findOrFail($id);

        $data = [
            'title' => 'Detail User: ' . $user->name,
            'user' => $user,
        ];

        return view('backend.users.show', $data);
    }

    /**
     * NOTE: Tampilkan form edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $owners = User::where('role', 'owner')->get();

        $data = [
            'title' => 'Edit User: ' . $user->name,
            'user' => $user,
            'owners' => $owners,
        ];

        return view('backend.users.edit', $data);
    }

    /**
     * NOTE: Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldData = $user->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:superadmin,owner,kasir',
            'owner_id' => 'required_if:role,kasir|nullable|exists:users,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'owner_id' => $request->role === 'kasir' ? $request->owner_id : null,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Upload avatar baru
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($userData);

        // Log aktivitas
        UserActivityLog::logUpdate('user', $oldData, $user->fresh()->toArray());

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    /**
     * NOTE: Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $oldData = $user->toArray();

        // Hapus avatar
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        // Log aktivitas
        UserActivityLog::logDelete('user', $oldData);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * NOTE: Toggle status aktif user
     */
    public function toggleActive($id)
    {
        $user = User::findOrFail($id);

        // Jangan nonaktifkan diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $oldData = $user->toArray();
        $user->is_active = !$user->is_active;
        $user->save();

        // Log aktivitas
        UserActivityLog::logUpdate('user', $oldData, $user->fresh()->toArray());

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "User berhasil {$status}.");
    }
}
