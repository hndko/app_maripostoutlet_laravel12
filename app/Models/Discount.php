<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel discounts untuk diskon per outlet
     * Types: percentage (%), fixed (nominal)
     * Relationships:
     * - outlet() : outlet tempat diskon ini
     * - transactions() : transaksi yang menggunakan diskon ini
     */

    protected $fillable = [
        'outlet_id',
        'name',
        'code',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * NOTE: Relasi ke outlet
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * NOTE: Relasi ke transaksi
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * NOTE: Cek apakah diskon masih berlaku
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $today = now()->toDateString();

        if ($this->start_date && $this->start_date > $today) {
            return false;
        }

        if ($this->end_date && $this->end_date < $today) {
            return false;
        }

        return true;
    }

    /**
     * NOTE: Hitung nilai diskon berdasarkan subtotal
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_purchase) {
            return 0;
        }

        if ($this->type === 'fixed') {
            return min($this->value, $subtotal);
        }

        // Percentage
        $discount = $subtotal * ($this->value / 100);

        if ($this->max_discount !== null) {
            $discount = min($discount, $this->max_discount);
        }

        return $discount;
    }
}
