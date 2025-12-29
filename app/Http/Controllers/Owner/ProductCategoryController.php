<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\ProductCategory;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    /**
     * NOTE: Tampilkan daftar kategori produk per outlet
     */
    public function index($outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $categories = $outlet->categories()->withCount('products')->orderBy('sort_order')->get();

        $data = [
            'title' => 'Kategori Produk - ' . $outlet->name,
            'outlet' => $outlet,
            'categories' => $categories,
        ];

        return view('owner.categories.index', $data);
    }

    /**
     * NOTE: Tampilkan form create kategori
     */
    public function create($outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);

        $data = [
            'title' => 'Tambah Kategori',
            'outlet' => $outlet,
        ];

        return view('owner.categories.create', $data);
    }

    /**
     * NOTE: Simpan kategori baru
     */
    public function store(Request $request, $outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $data = [
            'outlet_id' => $outlet->id,
            'name' => $request->name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = ProductCategory::create($data);

        UserActivityLog::logCreate('product_category', $category->toArray());

        return redirect()->route('owner.categories.index', $outlet_id)
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * NOTE: Tampilkan form edit kategori
     */
    public function edit($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $category = ProductCategory::where('outlet_id', $outlet->id)->findOrFail($id);

        $data = [
            'title' => 'Edit Kategori: ' . $category->name,
            'outlet' => $outlet,
            'category' => $category,
        ];

        return view('owner.categories.edit', $data);
    }

    /**
     * NOTE: Update kategori
     */
    public function update(Request $request, $outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $category = ProductCategory::where('outlet_id', $outlet->id)->findOrFail($id);
        $oldData = $category->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        UserActivityLog::logUpdate('product_category', $oldData, $category->fresh()->toArray());

        return redirect()->route('owner.categories.index', $outlet_id)
            ->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * NOTE: Hapus kategori
     */
    public function destroy($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $category = ProductCategory::where('outlet_id', $outlet->id)->findOrFail($id);

        if ($category->products()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        $oldData = $category->toArray();

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        UserActivityLog::logDelete('product_category', $oldData);

        return redirect()->route('owner.categories.index', $outlet_id)
            ->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * NOTE: Toggle status aktif kategori
     */
    public function toggleActive($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $category = ProductCategory::where('outlet_id', $outlet->id)->findOrFail($id);
        $oldData = $category->toArray();

        $category->is_active = !$category->is_active;
        $category->save();

        UserActivityLog::logUpdate('product_category', $oldData, $category->fresh()->toArray());

        $status = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Kategori berhasil {$status}.");
    }

    private function getOwnerOutlet($id): Outlet
    {
        return Outlet::where('owner_id', auth()->id())->findOrFail($id);
    }
}
