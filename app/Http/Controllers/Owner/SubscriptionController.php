<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPayment;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * NOTE: Tampilkan status subscription owner
     */
    public function index()
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;
        $payments = SubscriptionPayment::whereHas('subscription', function ($q) use ($user) {
            $q->where('owner_id', $user->id);
        })->orderBy('created_at', 'desc')->limit(10)->get();

        $data = [
            'title' => 'Status Langganan',
            'subscription' => $subscription,
            'remainingDays' => $subscription?->remainingDays(),
            'payments' => $payments,
        ];

        return view('backend.subscription.index', $data);
    }

    /**
     * NOTE: Tampilkan daftar paket yang tersedia
     */
    public function packages()
    {
        $packages = SubscriptionPackage::getAvailablePackages();

        $data = [
            'title' => 'Pilih Paket Langganan',
            'packages' => $packages,
        ];

        return view('backend.subscription.packages', $data);
    }

    /**
     * NOTE: Halaman checkout untuk paket tertentu
     */
    public function checkout($package_id)
    {
        $package = SubscriptionPackage::where('is_active', true)
            ->where('type', '!=', 'trial')
            ->findOrFail($package_id);

        // Lifetime hanya bisa melalui superadmin
        if ($package->type === 'lifetime') {
            return redirect()->route('owner.subscription.packages')
                ->with('info', 'Untuk paket Lifetime, silakan hubungi admin.');
        }

        $gateways = PaymentGateway::where('is_active', true)->get();

        $data = [
            'title' => 'Checkout: ' . $package->name,
            'package' => $package,
            'gateways' => $gateways,
        ];

        return view('backend.subscription.checkout', $data);
    }

    /**
     * NOTE: Proses pembayaran subscription
     */
    public function pay(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:subscription_packages,id',
            'payment_method' => 'required|in:manual,payment_gateway',
            'payment_gateway_id' => 'required_if:payment_method,payment_gateway|nullable|exists:payment_gateways,id',
        ]);

        $user = auth()->user();
        $package = SubscriptionPackage::findOrFail($request->package_id);

        // Buat atau update subscription
        $subscription = $user->subscriptions()
            ->where('status', '!=', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$subscription) {
            $subscription = Subscription::create([
                'owner_id' => $user->id,
                'package_id' => $package->id,
                'status' => 'pending',
                'start_date' => now(),
                'end_date' => now()->addDays($package->duration_days ?? 30),
            ]);
        } else {
            $subscription->package_id = $package->id;
            $subscription->save();
        }

        // Buat payment record
        $payment = SubscriptionPayment::create([
            'subscription_id' => $subscription->id,
            'invoice_number' => SubscriptionPayment::generateInvoiceNumber(),
            'amount' => $package->price,
            'payment_method' => $request->payment_method,
            'payment_gateway_id' => $request->payment_method === 'payment_gateway' ? $request->payment_gateway_id : null,
            'status' => 'pending',
            'expired_at' => now()->addHours(24),
        ]);

        UserActivityLog::logCreate('subscription_payment', $payment->toArray());

        if ($request->payment_method === 'manual') {
            return redirect()->route('owner.subscription.payment-status', $payment->id)
                ->with('info', 'Silakan transfer ke rekening yang tertera dan tunggu konfirmasi admin.');
        }

        // TODO: Integrasi dengan payment gateway (Midtrans/Duitku)
        $gateway = PaymentGateway::find($request->payment_gateway_id);

        // Untuk sekarang redirect ke halaman status
        return redirect()->route('owner.subscription.payment-status', $payment->id)
            ->with('info', 'Pembayaran melalui ' . $gateway->display_name . ' sedang diproses.');
    }

    /**
     * NOTE: Tampilkan status pembayaran
     */
    public function paymentStatus($payment_id)
    {
        $user = auth()->user();
        $payment = SubscriptionPayment::with(['subscription.package', 'paymentGateway'])
            ->whereHas('subscription', function ($q) use ($user) {
                $q->where('owner_id', $user->id);
            })
            ->findOrFail($payment_id);

        $data = [
            'title' => 'Status Pembayaran',
            'payment' => $payment,
        ];

        return view('backend.subscription.payment-status', $data);
    }

    /**
     * NOTE: Callback dari Midtrans
     */
    public function midtransCallback(Request $request)
    {
        // TODO: Implement Midtrans callback handling
        // 1. Verify signature
        // 2. Update payment status
        // 3. Activate subscription if paid

        return response()->json(['status' => 'ok']);
    }

    /**
     * NOTE: Callback dari Duitku
     */
    public function duitkuCallback(Request $request)
    {
        // TODO: Implement Duitku callback handling
        // 1. Verify signature
        // 2. Update payment status
        // 3. Activate subscription if paid

        return response()->json(['status' => 'ok']);
    }
}
