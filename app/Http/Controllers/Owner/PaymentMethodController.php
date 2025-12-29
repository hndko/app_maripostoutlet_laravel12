<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\PaymentGateway;
use App\Models\PaymentMethod;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    /**
     * NOTE: Tampilkan daftar metode pembayaran per outlet
     */
    public function index($outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $paymentMethods = $outlet->paymentMethods()->with('paymentGateway')->get();

        $data = [
            'title' => 'Metode Pembayaran - ' . $outlet->name,
            'outlet' => $outlet,
            'paymentMethods' => $paymentMethods,
        ];

        return view('owner.payment-methods.index', $data);
    }

    /**
     * NOTE: Tampilkan form create metode pembayaran
     */
    public function create($outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $gateways = PaymentGateway::where('is_active', true)->get();

        $data = [
            'title' => 'Tambah Metode Pembayaran',
            'outlet' => $outlet,
            'gateways' => $gateways,
        ];

        return view('owner.payment-methods.create', $data);
    }

    /**
     * NOTE: Simpan metode pembayaran baru
     */
    public function store(Request $request, $outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);

        $request->validate([
            'type' => 'required|in:cash,qris_static,transfer,payment_gateway',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'payment_gateway_id' => 'required_if:type,payment_gateway|nullable|exists:payment_gateways,id',
            // Config fields
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'account_name' => 'nullable|string|max:255',
        ]);

        $config = [];

        // Build config based on type
        if ($request->type === 'qris_static' && $request->hasFile('qris_image')) {
            $config['qris_image'] = $request->file('qris_image')->store('payment-methods', 'public');
        }

        if ($request->type === 'transfer') {
            $config['bank_name'] = $request->bank_name;
            $config['account_number'] = $request->account_number;
            $config['account_name'] = $request->account_name;
        }

        $method = PaymentMethod::create([
            'outlet_id' => $outlet->id,
            'type' => $request->type,
            'name' => $request->name,
            'description' => $request->description,
            'payment_gateway_id' => $request->type === 'payment_gateway' ? $request->payment_gateway_id : null,
            'config' => !empty($config) ? $config : null,
            'is_active' => true,
        ]);

        UserActivityLog::logCreate('payment_method', $method->toArray());

        return redirect()->route('owner.payment-methods.index', $outlet_id)
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    /**
     * NOTE: Tampilkan form edit metode pembayaran
     */
    public function edit($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $method = PaymentMethod::where('outlet_id', $outlet->id)->findOrFail($id);
        $gateways = PaymentGateway::where('is_active', true)->get();

        $data = [
            'title' => 'Edit Metode Pembayaran: ' . $method->name,
            'outlet' => $outlet,
            'paymentMethod' => $method,
            'gateways' => $gateways,
        ];

        return view('owner.payment-methods.edit', $data);
    }

    /**
     * NOTE: Update metode pembayaran
     */
    public function update(Request $request, $outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $method = PaymentMethod::where('outlet_id', $outlet->id)->findOrFail($id);
        $oldData = $method->toArray();

        $request->validate([
            'type' => 'required|in:cash,qris_static,transfer,payment_gateway',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'payment_gateway_id' => 'required_if:type,payment_gateway|nullable|exists:payment_gateways,id',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'account_name' => 'nullable|string|max:255',
        ]);

        $config = $method->config ?? [];

        if ($request->type === 'qris_static' && $request->hasFile('qris_image')) {
            // Delete old image
            if (isset($config['qris_image']) && Storage::disk('public')->exists($config['qris_image'])) {
                Storage::disk('public')->delete($config['qris_image']);
            }
            $config['qris_image'] = $request->file('qris_image')->store('payment-methods', 'public');
        }

        if ($request->type === 'transfer') {
            $config['bank_name'] = $request->bank_name;
            $config['account_number'] = $request->account_number;
            $config['account_name'] = $request->account_name;
        }

        $method->update([
            'type' => $request->type,
            'name' => $request->name,
            'description' => $request->description,
            'payment_gateway_id' => $request->type === 'payment_gateway' ? $request->payment_gateway_id : null,
            'config' => !empty($config) ? $config : null,
        ]);

        UserActivityLog::logUpdate('payment_method', $oldData, $method->fresh()->toArray());

        return redirect()->route('owner.payment-methods.index', $outlet_id)
            ->with('success', 'Metode pembayaran berhasil diupdate.');
    }

    /**
     * NOTE: Hapus metode pembayaran
     */
    public function destroy($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $method = PaymentMethod::where('outlet_id', $outlet->id)->findOrFail($id);

        if ($method->transactions()->exists()) {
            return back()->with('error', 'Metode pembayaran tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }

        $oldData = $method->toArray();

        // Delete QRIS image if exists
        if (isset($method->config['qris_image']) && Storage::disk('public')->exists($method->config['qris_image'])) {
            Storage::disk('public')->delete($method->config['qris_image']);
        }

        $method->delete();

        UserActivityLog::logDelete('payment_method', $oldData);

        return redirect()->route('owner.payment-methods.index', $outlet_id)
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }

    /**
     * NOTE: Toggle status aktif metode pembayaran
     */
    public function toggleActive($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $method = PaymentMethod::where('outlet_id', $outlet->id)->findOrFail($id);
        $oldData = $method->toArray();

        $method->is_active = !$method->is_active;
        $method->save();

        UserActivityLog::logUpdate('payment_method', $oldData, $method->fresh()->toArray());

        $status = $method->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Metode pembayaran berhasil {$status}.");
    }

    private function getOwnerOutlet($id): Outlet
    {
        return Outlet::where('owner_id', auth()->id())->findOrFail($id);
    }
}
