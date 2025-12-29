<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * NOTE: Middleware untuk cek apakah user masih aktif (is_active = true)
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['inactive' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.']);
        }

        return $next($request);
    }
}
