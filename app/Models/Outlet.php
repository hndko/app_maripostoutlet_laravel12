<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel outlets untuk outlet/toko milik owner
     * Relationships:
     * - owner() : pemilik outlet
     * - products() : produk di outlet ini
     * - categories() : kategori produk di outlet ini
     * - paymentMethods() : metode pembayaran outlet
     * - discounts() : diskon di outlet ini
     * - transactions() : transaksi di outlet ini
     */

    protected $fillable = [
        'owner_id',
        'name',
        'address',
        'phone',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * NOTE: Relasi ke owner
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * NOTE: Relasi ke produk
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * NOTE: Relasi ke kategori produk
     */
    public function categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    /**
     * NOTE: Relasi ke metode pembayaran
     */
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    /**
     * NOTE: Relasi ke diskon
     */
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    /**
     * NOTE: Relasi ke transaksi
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
