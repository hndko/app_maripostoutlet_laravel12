<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    /**
     * NOTE: Halaman pilih outlet untuk POS
     */
    public function index()
    {
        $user = auth()->user();

        // Kasir hanya bisa akses outlet milik owner-nya
        if ($user->isCashier()) {
            $outlets = Outlet::where('owner_id', $user->owner_id)
                ->where('is_active', true)
                ->get();
        } else {
            // Owner bisa akses semua outlet miliknya
            $outlets = $user->outlets()->where('is_active', true)->get();
        }

        // Jika hanya 1 outlet, langsung redirect
        if ($outlets->count() === 1) {
            return redirect()->route('pos.outlet', $outlets->first()->id);
        }

        $data = [
            'title' => 'Pilih Outlet',
            'outlets' => $outlets,
        ];

        return view('backend.pos.select-outlet', $data);
    }

    /**
     * NOTE: Halaman POS untuk outlet tertentu
     */
    public function outlet($outlet_id)
    {
        $outlet = $this->getAccessibleOutlet($outlet_id);
        $categories = $outlet->categories()->where('is_active', true)->orderBy('sort_order')->get();
        $paymentMethods = $outlet->paymentMethods()->where('is_active', true)->get();

        $data = [
            'title' => 'POS - ' . $outlet->name,
            'outlet' => $outlet,
            'categories' => $categories,
            'paymentMethods' => $paymentMethods,
        ];

        return view('backend.pos.index', $data);
    }

    /**
     * NOTE: API untuk mengambil produk (untuk AJAX)
     */
    public function getProducts(Request $request, $outlet_id)
    {
        $outlet = $this->getAccessibleOutlet($outlet_id);

        $query = Product::where('outlet_id', $outlet->id)
            ->where('is_active', true);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->price,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
                'use_stock' => $product->use_stock,
                'stock' => $product->stock,
            ];
        });

        return response()->json($products);
    }

    /**
     * NOTE: Cek validitas diskon
     */
    public function checkDiscount(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $discount = Discount::where('outlet_id', $request->outlet_id)
            ->where('code', strtoupper($request->code))
            ->where('is_active', true)
            ->first();

        if (!$discount) {
            return response()->json(['valid' => false, 'message' => 'Kode diskon tidak ditemukan.']);
        }

        if (!$discount->isValid()) {
            return response()->json(['valid' => false, 'message' => 'Diskon sudah tidak berlaku.']);
        }

        $discountAmount = $discount->calculateDiscount($request->subtotal);

        return response()->json([
            'valid' => true,
            'discount' => [
                'id' => $discount->id,
                'name' => $discount->name,
                'type' => $discount->type,
                'value' => $discount->value,
                'amount' => $discountAmount,
            ],
        ]);
    }

    /**
     * NOTE: Proses checkout transaksi
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount_id' => 'nullable|exists:discounts,id',
            'paid_amount' => 'required|numeric|min:0',
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $outlet = $this->getAccessibleOutlet($request->outlet_id);

        try {
            DB::beginTransaction();

            // Hitung subtotal
            $subtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Cek stok
                if ($product->use_stock && $product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi.");
                }

                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $itemsData[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal,
                    'notes' => $item['notes'] ?? null,
                ];
            }

            // Hitung diskon
            $discountAmount = 0;
            $discount = null;

            if ($request->filled('discount_id')) {
                $discount = Discount::find($request->discount_id);
                if ($discount && $discount->isValid()) {
                    $discountAmount = $discount->calculateDiscount($subtotal);
                }
            }

            // Hitung pajak
            $taxPercentage = (float) setting('tax_percentage', 0);
            $taxAmount = ($subtotal - $discountAmount) * ($taxPercentage / 100);

            // Total
            $total = $subtotal - $discountAmount + $taxAmount;

            // Hitung kembalian
            $changeAmount = max(0, $request->paid_amount - $total);

            // Buat transaksi
            $transaction = Transaction::create([
                'outlet_id' => $outlet->id,
                'cashier_id' => auth()->id(),
                'invoice_number' => Transaction::generateInvoiceNumber($outlet->id),
                'subtotal' => $subtotal,
                'discount_id' => $discount?->id,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'total' => $total,
                'payment_method_id' => $request->payment_method_id,
                'payment_status' => 'paid',
                'paid_amount' => $request->paid_amount,
                'change_amount' => $changeAmount,
                'customer_name' => $request->customer_name,
                'notes' => $request->notes,
            ]);

            // Buat item transaksi dan update stok
            foreach ($itemsData as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'product_price' => $item['product']->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                    'notes' => $item['notes'],
                ]);

                // Update stok
                $item['product']->decreaseStock($item['quantity']);
            }

            DB::commit();

            UserActivityLog::logCreate('transaction', $transaction->toArray());

            return response()->json([
                'success' => true,
                'transaction' => $transaction,
                'redirect' => route('pos.receipt', $transaction->id),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * NOTE: Tampilkan struk transaksi
     */
    public function receipt($id)
    {
        $transaction = Transaction::with(['outlet', 'cashier', 'paymentMethod', 'discount', 'items'])
            ->findOrFail($id);

        $data = [
            'title' => 'Struk: ' . $transaction->invoice_number,
            'transaction' => $transaction,
        ];

        return view('backend.pos.receipt', $data);
    }

    /**
     * NOTE: Helper untuk mendapatkan outlet yang bisa diakses
     */
    private function getAccessibleOutlet($id): Outlet
    {
        $user = auth()->user();

        if ($user->isCashier()) {
            return Outlet::where('id', $id)
                ->where('owner_id', $user->owner_id)
                ->where('is_active', true)
                ->firstOrFail();
        }

        return Outlet::where('id', $id)
            ->where('owner_id', $user->id)
            ->where('is_active', true)
            ->firstOrFail();
    }
}
