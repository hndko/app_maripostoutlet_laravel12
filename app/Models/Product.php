<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel products untuk produk
     * Relationships:
     * - outlet() : outlet tempat produk ini
     * - category() : kategori produk ini
     * - transactionItems() : item transaksi yang menggunakan produk ini
     */

    protected $fillable = [
        'outlet_id',
        'category_id',
        'sku',
        'name',
        'description',
        'image',
        'price',
        'cost_price',
        'use_stock',
        'stock',
        'min_stock',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'use_stock' => 'boolean',
        'stock' => 'integer',
        'min_stock' => 'integer',
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
     * NOTE: Relasi ke kategori
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * NOTE: Relasi ke item transaksi
     */
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * NOTE: Cek apakah stok menipis
     */
    public function isLowStock(): bool
    {
        if (!$this->use_stock) {
            return false;
        }

        return $this->stock <= $this->min_stock;
    }

    /**
     * NOTE: Kurangi stok
     */
    public function decreaseStock(int $quantity): bool
    {
        if (!$this->use_stock) {
            return true;
        }

        if ($this->stock < $quantity) {
            return false;
        }

        $this->stock -= $quantity;
        return $this->save();
    }

    /**
     * NOTE: Tambah stok
     */
    public function increaseStock(int $quantity): bool
    {
        if (!$this->use_stock) {
            return true;
        }

        $this->stock += $quantity;
        return $this->save();
    }
}
