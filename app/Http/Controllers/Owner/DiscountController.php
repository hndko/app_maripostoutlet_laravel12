<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Outlet;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * NOTE: Tampilkan daftar diskon per outlet
     */
    public function index($outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $discounts = $outlet->discounts()->withCount('transactions')->get();

        $data = [
            'title' => 'Diskon - ' . $outlet->name,
            'outlet' => $outlet,
            'discounts' => $discounts,
        ];

        return view('backend.discounts.index', $data);
    }

    /**
     * NOTE: Tampilkan form create diskon
     */
    public function create($outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);

        $data = [
            'title' => 'Tambah Diskon',
            'outlet' => $outlet,
        ];

        return view('backend.discounts.create', $data);
    }

    /**
     * NOTE: Simpan diskon baru
     */
    public function store(Request $request, $outlet_id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:discounts,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $discount = Discount::create([
            'outlet_id' => $outlet->id,
            'name' => $request->name,
            'code' => $request->code ? strtoupper($request->code) : null,
            'type' => $request->type,
            'value' => $request->value,
            'min_purchase' => $request->min_purchase ?? 0,
            'max_discount' => $request->type === 'percentage' ? $request->max_discount : null,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true,
        ]);

        UserActivityLog::logCreate('discount', $discount->toArray());

        return redirect()->route('owner.discounts.index', $outlet_id)
            ->with('success', 'Diskon berhasil ditambahkan.');
    }

    /**
     * NOTE: Tampilkan form edit diskon
     */
    public function edit($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $discount = Discount::where('outlet_id', $outlet->id)->findOrFail($id);

        $data = [
            'title' => 'Edit Diskon: ' . $discount->name,
            'outlet' => $outlet,
            'discount' => $discount,
        ];

        return view('backend.discounts.edit', $data);
    }

    /**
     * NOTE: Update diskon
     */
    public function update(Request $request, $outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $discount = Discount::where('outlet_id', $outlet->id)->findOrFail($id);
        $oldData = $discount->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:discounts,code,' . $id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $discount->update([
            'name' => $request->name,
            'code' => $request->code ? strtoupper($request->code) : null,
            'type' => $request->type,
            'value' => $request->value,
            'min_purchase' => $request->min_purchase ?? 0,
            'max_discount' => $request->type === 'percentage' ? $request->max_discount : null,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        UserActivityLog::logUpdate('discount', $oldData, $discount->fresh()->toArray());

        return redirect()->route('owner.discounts.index', $outlet_id)
            ->with('success', 'Diskon berhasil diupdate.');
    }

    /**
     * NOTE: Hapus diskon
     */
    public function destroy($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $discount = Discount::where('outlet_id', $outlet->id)->findOrFail($id);

        $oldData = $discount->toArray();
        $discount->delete();

        UserActivityLog::logDelete('discount', $oldData);

        return redirect()->route('owner.discounts.index', $outlet_id)
            ->with('success', 'Diskon berhasil dihapus.');
    }

    /**
     * NOTE: Toggle status aktif diskon
     */
    public function toggleActive($outlet_id, $id)
    {
        $outlet = $this->getOwnerOutlet($outlet_id);
        $discount = Discount::where('outlet_id', $outlet->id)->findOrFail($id);
        $oldData = $discount->toArray();

        $discount->is_active = !$discount->is_active;
        $discount->save();

        UserActivityLog::logUpdate('discount', $oldData, $discount->fresh()->toArray());

        $status = $discount->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Diskon berhasil {$status}.");
    }

    private function getOwnerOutlet($id): Outlet
    {
        return Outlet::where('owner_id', auth()->id())->findOrFail($id);
    }
}
