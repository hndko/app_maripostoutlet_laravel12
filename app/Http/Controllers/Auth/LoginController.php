<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * NOTE: Tampilkan form login
     */
    public function showLoginForm()
    {
        $data = [
            'title' => 'Login',
        ];

        return view('auth.login', $data);
    }

    /**
     * NOTE: Proses login
     * - Validasi email dan password
     * - Cek is_active user
     * - Cek subscription untuk owner/kasir
     * - Log aktivitas login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Cek apakah user ada
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
        }

        // Cek password
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        // Cek is_active
        if (!$user->is_active) {
            return back()->withErrors(['inactive' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.'])->withInput();
        }

        // Untuk kasir, cek apakah owner subscription-nya aktif
        if ($user->isCashier()) {
            if (!$user->owner || !$user->owner->hasActiveSubscription()) {
                return back()->withErrors(['subscription' => 'Langganan pemilik toko Anda telah habis. Silakan hubungi pemilik toko.'])->withInput();
            }
        }

        // Login
        Auth::login($user, $remember);

        // Log aktivitas
        UserActivityLog::logLogin($user->id);

        // Redirect berdasarkan role
        return redirect()->route('dashboard');
    }

    /**
     * NOTE: Proses logout
     */
    public function logout(Request $request)
    {
        $userId = auth()->id();

        // Log aktivitas
        if ($userId) {
            UserActivityLog::logLogout($userId);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    /**
     * NOTE: Redirect ke SSO provider (Google, Facebook, dll)
     */
    public function redirectToProvider(string $provider)
    {
        // TODO: Implement SSO dengan Laravel Socialite
        // Untuk sementara redirect ke login
        return redirect()->route('login')->with('info', 'SSO akan segera tersedia.');
    }

    /**
     * NOTE: Handle callback dari SSO provider
     */
    public function handleProviderCallback(string $provider)
    {
        // TODO: Implement SSO dengan Laravel Socialite
        return redirect()->route('login');
    }
}
