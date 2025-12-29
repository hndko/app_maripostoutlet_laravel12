<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel transaction_items untuk item per transaksi
     * product_name dan product_price adalah snapshot pada saat transaksi
     * Relationships:
     * - transaction() : transaksi induk
     * - product() : produk asli
     */

    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    /**
     * NOTE: Relasi ke transaksi
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * NOTE: Relasi ke produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * NOTE: Hitung subtotal berdasarkan harga dan quantity
     */
    public function calculateSubtotal(): float
    {
        return $this->product_price * $this->quantity;
    }
}
