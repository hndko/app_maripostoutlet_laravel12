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

        return match ($user->role) {
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'owner' => redirect()->route('owner.dashboard'),
            'kasir' => redirect()->route('pos.index'),
            default => redirect()->route('login'),
        };
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
        $data = [
            'title' => 'Dashboard Superadmin',
            'totalOwners' => User::where('role', 'owner')->count(),
            'totalCashiers' => User::where('role', 'kasir')->count(),
            'activeSubscriptions' => Subscription::where('status', 'active')->count(),
            'pendingPayments' => SubscriptionPayment::where('status', 'pending')->count(),
            'monthlyRevenue' => SubscriptionPayment::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount'),
            'recentPayments' => SubscriptionPayment::with(['subscription.owner', 'subscription.package'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
            'expiringSubscriptions' => Subscription::with(['owner', 'package'])
                ->where('status', 'active')
                ->whereNotNull('end_date')
                ->whereBetween('end_date', [now(), now()->addDays(7)])
                ->orderBy('end_date')
                ->limit(10)
                ->get(),
        ];

        return view('superadmin.dashboard', $data);
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
        $user = auth()->user();

        // Ambil subscription aktif
        $subscription = $user->activeSubscription;

        // Hitung statistik
        $outletIds = $user->outlets()->pluck('id');

        $data = [
            'title' => 'Dashboard Owner',
            'subscription' => $subscription,
            'remainingDays' => $subscription?->remainingDays(),
            'isExpiringSoon' => $subscription?->isExpiringSoon(7) ?? false,
            'totalOutlets' => $user->outlets()->count(),
            'totalProducts' => \App\Models\Product::whereIn('outlet_id', $outletIds)->count(),
            'totalCashiers' => $user->cashiers()->count(),
            'todayTransactions' => Transaction::whereIn('outlet_id', $outletIds)
                ->whereDate('created_at', now())
                ->count(),
            'todayRevenue' => Transaction::whereIn('outlet_id', $outletIds)
                ->whereDate('created_at', now())
                ->where('payment_status', 'paid')
                ->sum('total'),
            'weeklyRevenue' => Transaction::whereIn('outlet_id', $outletIds)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->where('payment_status', 'paid')
                ->sum('total'),
            'monthlyRevenue' => Transaction::whereIn('outlet_id', $outletIds)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('payment_status', 'paid')
                ->sum('total'),
            'recentTransactions' => Transaction::with(['outlet', 'cashier'])
                ->whereIn('outlet_id', $outletIds)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
            'outlets' => $user->outlets()->withCount(['products', 'transactions'])->get(),
        ];

        return view('owner.dashboard', $data);
    }
}
