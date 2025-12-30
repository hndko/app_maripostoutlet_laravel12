<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * NOTE: Redirect ke dashboard sesuai role
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isCashier()) {
            return redirect()->route('pos.index');
        }

        if ($user->isSuperadmin()) {
            $stats = [
                'total_owners' => User::where('role', 'owner')->count(),
                'total_cashiers' => User::where('role', 'kasir')->count(),
                'active_subscriptions' => Subscription::where('status', 'active')->count(),
                'pending_payments' => SubscriptionPayment::where('status', 'pending')->count(),
                'monthly_revenue' => SubscriptionPayment::where('status', 'paid')
                    ->whereMonth('paid_at', now()->month)
                    ->whereYear('paid_at', now()->year)
                    ->sum('amount'),
            ];
        } else {
            $outletIds = $user->outlets()->pluck('id');
            $stats = [
                'total_outlets' => $user->outlets()->count(),
                'total_products' => \App\Models\Product::whereIn('outlet_id', $outletIds)->count(),
                'total_cashiers' => $user->cashiers()->count(),
                'today_transactions' => Transaction::whereIn('outlet_id', $outletIds)
                    ->whereDate('created_at', now())
                    ->count(),
                'today_revenue' => Transaction::whereIn('outlet_id', $outletIds)
                    ->whereDate('created_at', now())
                    ->where('payment_status', 'paid')
                    ->sum('total'),
                'weekly_revenue' => Transaction::whereIn('outlet_id', $outletIds)
                    ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->where('payment_status', 'paid')
                    ->sum('total'),
            ];
        }

        return view('backend.dashboard', compact('stats'));
    }

    /**
     * NOTE: Dashboard Superadmin
     * - Total users (owner, kasir)
     * - Total subscription aktif
     * - Pembayaran pending
     * - Revenue bulanan
     */
    public function superadmin()
    {
        return redirect()->route('dashboard');
    }

    /**
     * NOTE: Dashboard Owner
     * - Info subscription
     * - Total outlet
     * - Total produk
     * - Total kasir
     * - Transaksi hari ini
     * - Revenue hari ini
     */
    public function owner()
    {
        return redirect()->route('dashboard');
    }
}
