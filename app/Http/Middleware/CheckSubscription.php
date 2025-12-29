<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * NOTE: Middleware untuk cek subscription owner masih aktif
     * - Superadmin: selalu lolos
     * - Owner: cek apakah subscription aktif
     * - Kasir: cek subscription owner-nya
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Superadmin selalu akses
        if ($user->isSuperadmin()) {
            return $next($request);
        }

        // Cek subscription
        if (!$user->hasActiveSubscription()) {
            // Jika kasir, dia tidak bisa akses sama sekali
            if ($user->isCashier()) {
                auth()->logout();
                return redirect()->route('login')
                    ->withErrors(['subscription' => 'Langganan pemilik toko Anda telah habis. Silakan hubungi pemilik toko.']);
            }

            // Jika owner, redirect ke halaman pembayaran subscription
            return redirect()->route('owner.subscription.index')
                ->with('warning', 'Langganan Anda telah habis. Silakan perpanjang untuk melanjutkan.');
        }

        return $next($request);
    }
}
