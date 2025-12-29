<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * NOTE: Tampilkan daftar transaksi dengan filter
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $outletIds = $user->outlets()->pluck('id');

        $query = Transaction::with(['outlet', 'cashier', 'paymentMethod'])
            ->whereIn('outlet_id', $outletIds);

        if ($request->filled('outlet_id')) {
            $query->where('outlet_id', $request->outlet_id);
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $data = [
            'title' => 'Riwayat Transaksi',
            'transactions' => $query->orderBy('created_at', 'desc')->get(),
            'outlets' => $user->outlets,
        ];

        return view('owner.transactions.index', $data);
    }

    /**
     * NOTE: Tampilkan detail transaksi
     */
    public function show($id)
    {
        $user = auth()->user();
        $outletIds = $user->outlets()->pluck('id');

        $transaction = Transaction::with(['outlet', 'cashier', 'paymentMethod', 'discount', 'items.product'])
            ->whereIn('outlet_id', $outletIds)
            ->findOrFail($id);

        $data = [
            'title' => 'Detail Transaksi: ' . $transaction->invoice_number,
            'transaction' => $transaction,
        ];

        return view('owner.transactions.show', $data);
    }

    /**
     * NOTE: Cetak struk transaksi
     */
    public function print($id)
    {
        $user = auth()->user();
        $outletIds = $user->outlets()->pluck('id');

        $transaction = Transaction::with(['outlet', 'cashier', 'paymentMethod', 'discount', 'items.product'])
            ->whereIn('outlet_id', $outletIds)
            ->findOrFail($id);

        $data = [
            'title' => 'Struk: ' . $transaction->invoice_number,
            'transaction' => $transaction,
        ];

        return view('owner.transactions.print', $data);
    }
}
