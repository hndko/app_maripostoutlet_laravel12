<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * NOTE: Tampilkan daftar produk per outlet
     */
    public function index(Request $request, $outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);

        $query = Product::with('category')->where('outlet_id', $outlet->id);

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by stock
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->where('use_stock', true)
                    ->whereColumn('stock', '<=', 'min_stock');
            }
        }

        $data = [
            'title' => 'Produk - ' . $outlet->name,
            'outlet' => $outlet,
            'products' => $query->orderBy('name')->get(),
            'categories' => $outlet->categories()->where('is_active', true)->get(),
        ];

        return view('owner.products.index', $data);
    }

    /**
     * NOTE: Tampilkan form create produk
     */
    public function create($outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);

        // Cek limit produk dari subscription
        $user = auth()->user();
        $subscription = $user->activeSubscription;
        $maxProducts = $subscription?->getLimit('products');

        if ($maxProducts !== null) {
            $outletIds = $user->outlets()->pluck('id');
            $currentCount = Product::whereIn('outlet_id', $outletIds)->count();

            if ($currentCount >= $maxProducts) {
                return redirect()->route('owner.products.index', $outlet_id)
                    ->with('error', "Batas produk tercapai ({$maxProducts}). Upgrade paket untuk menambah produk.");
            }
        }

        $data = [
            'title' => 'Tambah Produk',
            'outlet' => $outlet,
            'categories' => $outlet->categories()->where('is_active', true)->get(),
        ];

        return view('owner.products.create', $data);
    }

    /**
     * NOTE: Simpan produk baru
     */
    public function store(Request $request, $outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);

        $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'sku' => 'nullable|string|max:100',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'use_stock' => 'boolean',
            'stock' => 'required_if:use_stock,1|nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        $data = [
            'outlet_id' => $outlet->id,
            'category_id' => $request->category_id,
            'sku' => $request->sku,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'use_stock' => $request->boolean('use_stock'),
            'stock' => $request->use_stock ? ($request->stock ?? 0) : 0,
            'min_stock' => $request->min_stock ?? 0,
            'is_active' => true,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        UserActivityLog::logCreate('product', $product->toArray());

        return redirect()->route('owner.products.index', $outlet_id)
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * NOTE: Tampilkan detail produk
     */
    public function show($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $product = Product::with('category')->where('outlet_id', $outlet->id)->findOrFail($id);

        $data = [
            'title' => 'Detail Produk: ' . $product->name,
            'outlet' => $outlet,
            'product' => $product,
        ];

        return view('owner.products.show', $data);
    }

    /**
     * NOTE: Tampilkan form edit produk
     */
    public function edit($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $product = Product::where('outlet_id', $outlet->id)->findOrFail($id);

        $data = [
            'title' => 'Edit Produk: ' . $product->name,
            'outlet' => $outlet,
            'product' => $product,
            'categories' => $outlet->categories()->where('is_active', true)->get(),
        ];

        return view('owner.products.edit', $data);
    }

    /**
     * NOTE: Update produk
     */
    public function update(Request $request, $outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $product = Product::where('outlet_id', $outlet->id)->findOrFail($id);
        $oldData = $product->toArray();

        $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'sku' => 'nullable|string|max:100',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'use_stock' => 'boolean',
            'stock' => 'required_if:use_stock,1|nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'sku' => $request->sku,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'use_stock' => $request->boolean('use_stock'),
            'stock' => $request->boolean('use_stock') ? ($request->stock ?? 0) : 0,
            'min_stock' => $request->min_stock ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        UserActivityLog::logUpdate('product', $oldData, $product->fresh()->toArray());

        return redirect()->route('owner.products.index', $outlet_id)
            ->with('success', 'Produk berhasil diupdate.');
    }

    /**
     * NOTE: Hapus produk
     */
    public function destroy($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $product = Product::where('outlet_id', $outlet->id)->findOrFail($id);

        if ($product->transactionItems()->exists()) {
            return back()->with('error', 'Produk tidak dapat dihapus karena memiliki riwayat transaksi.');
        }

        $oldData = $product->toArray();

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        UserActivityLog::logDelete('product', $oldData);

        return redirect()->route('owner.products.index', $outlet_id)
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * NOTE: Toggle status aktif produk
     */
    public function toggleActive($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $product = Product::where('outlet_id', $outlet->id)->findOrFail($id);
        $oldData = $product->toArray();

        $product->is_active = !$product->is_active;
        $product->save();

        UserActivityLog::logUpdate('product', $oldData, $product->fresh()->toArray());

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Produk berhasil {$status}.");
    }

    /**
     * NOTE: Update stok produk
     */
    public function updateStock(Request $request, $outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $product = Product::where('outlet_id', $outlet->id)->findOrFail($id);

        if (!$product->use_stock) {
            return back()->with('error', 'Produk ini tidak menggunakan stok.');
        }

        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $oldData = ['stock' => $product->stock];

        $product->stock = $request->stock;
        $product->save();

        UserActivityLog::logUpdate('product_stock', $oldData, ['stock' => $product->stock]);

        return back()->with('success', 'Stok berhasil diupdate.');
    }

    private function getOwnerOutlet($id): Outlet
    {
        return Outlet::where('owner_id', auth()->id())->findOrFail($id);
    }
}
