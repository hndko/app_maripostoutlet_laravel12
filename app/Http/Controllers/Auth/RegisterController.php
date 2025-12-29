<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * NOTE: Tampilkan form registrasi (hanya untuk owner)
     */
    public function showRegistrationForm()
    {
        $data = [
            'title' => 'Register',
        ];

        return view('auth.register', $data);
    }

    /**
     * NOTE: Proses registrasi owner baru
     * - Buat user dengan role owner
     * - Buat subscription trial otomatis 14 hari
     * - Login otomatis setelah register
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Buat user owner
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'owner',
            'is_active' => true,
            'email_verified_at' => now(), // Auto verify untuk sekarang
        ]);

        // Buat subscription trial
        $trialPackage = SubscriptionPackage::getTrialPackage();

        if ($trialPackage) {
            Subscription::create([
                'owner_id' => $user->id,
                'package_id' => $trialPackage->id,
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addDays($trialPackage->duration_days ?? 14),
                'auto_renew' => false,
            ]);
        }

        // Log aktivitas
        UserActivityLog::logCreate('user', $user->toArray(), $user->id);

        // Login otomatis
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Selamat datang! Akun Anda berhasil dibuat dengan masa trial ' . ($trialPackage->duration_days ?? 14) . ' hari.');
    }
}
