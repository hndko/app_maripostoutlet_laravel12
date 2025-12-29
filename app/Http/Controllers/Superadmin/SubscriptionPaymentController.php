<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayment;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;

class SubscriptionPaymentController extends Controller
{
    /**
     * NOTE: Tampilkan daftar pembayaran subscription
     */
    public function index(Request $request)
    {
        $query = SubscriptionPayment::with(['subscription.owner', 'subscription.package', 'paymentGateway']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $data = [
            'title' => 'Pembayaran Subscription',
            'payments' => $query->orderBy('created_at', 'desc')->get(),
            'pendingCount' => SubscriptionPayment::where('status', 'pending')->count(),
        ];

        return view('superadmin.subscription-payments.index', $data);
    }

    /**
     * NOTE: Tampilkan detail pembayaran
     */
    public function show($id)
    {
        $payment = SubscriptionPayment::with([
            'subscription.owner',
            'subscription.package',
            'paymentGateway',
            'approvedBy'
        ])->findOrFail($id);

        $data = [
            'title' => 'Detail Pembayaran',
            'payment' => $payment,
        ];

        return view('superadmin.subscription-payments.show', $data);
    }

    /**
     * NOTE: Approve pembayaran manual
     */
    public function approve(Request $request, $id)
    {
        $payment = SubscriptionPayment::findOrFail($id);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran ini sudah diproses sebelumnya.');
        }

        if ($payment->payment_method !== 'manual') {
            return back()->with('error', 'Hanya pembayaran manual yang dapat di-approve.');
        }

        $oldData = $payment->toArray();

        if ($payment->approve(auth()->id())) {
            // Log aktivitas
            UserActivityLog::logUpdate('subscription_payment_approve', $oldData, $payment->fresh()->toArray());

            return back()->with('success', 'Pembayaran berhasil di-approve. Subscription telah diaktifkan.');
        }

        return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
    }

    /**
     * NOTE: Reject pembayaran manual
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $payment = SubscriptionPayment::findOrFail($id);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran ini sudah diproses sebelumnya.');
        }

        $oldData = $payment->toArray();

        if ($payment->reject(auth()->id(), $request->reason)) {
            // Log aktivitas
            UserActivityLog::logUpdate('subscription_payment_reject', $oldData, $payment->fresh()->toArray());

            return back()->with('success', 'Pembayaran berhasil ditolak.');
        }

        return back()->with('error', 'Terjadi kesalahan saat memproses penolakan.');
    }
}
