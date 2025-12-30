<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * NOTE: Laporan penjualan
     */
    public function sales(Request $request)
    {
        $user = auth()->user();
        $outletIds = $user->outlets()->pluck('id');

        $query = Transaction::whereIn('outlet_id', $outletIds)
            ->where('payment_status', 'paid');

        if ($request->filled('outlet_id')) {
            $query->where('outlet_id', $request->outlet_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $data = [
            'title' => 'Laporan Penjualan',
            'totalTransactions' => $query->count(),
            'totalRevenue' => $query->sum('total'),
            'outlets' => $user->outlets,
        ];

        return view('backend.reports.sales', $data);
    }

    /**
     * NOTE: Laporan produk
     */
    public function products(Request $request)
    {
        $user = auth()->user();
        $outletIds = $user->outlets()->pluck('id');

        $data = [
            'title' => 'Laporan Produk',
            'outlets' => $user->outlets,
        ];

        return view('backend.reports.products', $data);
    }

    /**
     * NOTE: Laporan kasir
     */
    public function cashiers(Request $request)
    {
        $user = auth()->user();

        $data = [
            'title' => 'Laporan Kasir',
            'cashiers' => $user->cashiers,
        ];

        return view('backend.reports.cashiers', $data);
    }
}
