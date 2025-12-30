<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentGatewayController extends Controller
{
    /**
     * NOTE: Tampilkan daftar payment gateway
     */
    public function index()
    {
        $data = [
            'title' => 'Payment Gateways',
            'gateways' => PaymentGateway::all(),
        ];

        return view('backend.payment-gateways.index', $data);
    }

    /**
     * NOTE: Tampilkan form edit gateway
     */
    public function edit($id)
    {
        $gateway = PaymentGateway::findOrFail($id);

        $data = [
            'title' => 'Edit ' . $gateway->display_name,
            'gateway' => $gateway,
        ];

        return view('backend.payment-gateways.edit', $data);
    }

    /**
     * NOTE: Update konfigurasi gateway
     */
    public function update(Request $request, $id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        $oldData = $gateway->toArray();

        $request->validate([
            'display_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'display_name' => $request->display_name,
        ];

        // Upload logo
        if ($request->hasFile('logo')) {
            if ($gateway->logo && Storage::disk('public')->exists($gateway->logo)) {
                Storage::disk('public')->delete($gateway->logo);
            }
            $data['logo'] = $request->file('logo')->store('payment-gateways', 'public');
        }

        // Update config berdasarkan gateway
        if ($gateway->name === 'midtrans') {
            $request->validate([
                'merchant_id' => 'nullable|string',
                'client_key' => 'nullable|string',
                'server_key' => 'nullable|string',
            ]);

            $data['config'] = [
                'merchant_id' => $request->merchant_id,
                'client_key' => $request->client_key,
                'server_key' => $request->server_key,
            ];
        } elseif ($gateway->name === 'duitku') {
            $request->validate([
                'merchant_code' => 'nullable|string',
                'api_key' => 'nullable|string',
                'callback_url' => 'nullable|url',
            ]);

            $data['config'] = [
                'merchant_code' => $request->merchant_code,
                'api_key' => $request->api_key,
                'callback_url' => $request->callback_url,
            ];
        }

        $gateway->update($data);

        // Log aktivitas (tanpa config untuk keamanan)
        $logOldData = $oldData;
        $logNewData = $gateway->fresh()->toArray();
        unset($logOldData['config'], $logNewData['config']);

        UserActivityLog::logUpdate('payment_gateway', $logOldData, $logNewData);

        return redirect()->route('superadmin.payment-gateways.index')
            ->with('success', 'Payment gateway berhasil diupdate.');
    }

    /**
     * NOTE: Toggle status aktif gateway
     */
    public function toggleActive($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        $oldData = ['is_active' => $gateway->is_active];

        $gateway->is_active = !$gateway->is_active;
        $gateway->save();

        UserActivityLog::logUpdate('payment_gateway', $oldData, ['is_active' => $gateway->is_active]);

        $status = $gateway->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "{$gateway->display_name} berhasil {$status}.");
    }

    /**
     * NOTE: Toggle mode sandbox/production
     */
    public function toggleSandbox($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        $oldData = ['is_sandbox' => $gateway->is_sandbox];

        $gateway->is_sandbox = !$gateway->is_sandbox;
        $gateway->save();

        UserActivityLog::logUpdate('payment_gateway', $oldData, ['is_sandbox' => $gateway->is_sandbox]);

        $mode = $gateway->is_sandbox ? 'Sandbox' : 'Production';
        return back()->with('success', "{$gateway->display_name} sekarang dalam mode {$mode}.");
    }
}
