<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel transactions untuk transaksi penjualan
     * Payment Status: pending, paid, failed, refunded
     * Relationships:
     * - outlet() : outlet tempat transaksi ini
     * - cashier() : user yang melakukan transaksi
     * - discount() : diskon yang digunakan
     * - paymentMethod() : metode pembayaran
     * - items() : item-item dalam transaksi
     */

    protected $fillable = [
        'outlet_id',
        'cashier_id',
        'invoice_number',
        'subtotal',
        'discount_id',
        'discount_amount',
        'tax_amount',
        'total',
        'payment_method_id',
        'payment_status',
        'payment_reference',
        'paid_amount',
        'change_amount',
        'notes',
        'customer_name',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'change_amount' => 'decimal:2',
    ];

    /**
     * NOTE: Relasi ke outlet
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * NOTE: Relasi ke kasir
     */
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    /**
     * NOTE: Relasi ke diskon
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * NOTE: Relasi ke metode pembayaran
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * NOTE: Relasi ke item transaksi
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * NOTE: Generate invoice number
     */
    public static function generateInvoiceNumber(int $outletId): string
    {
        $prefix = 'INV';
        $date = now()->format('Ymd');
        $count = self::where('outlet_id', $outletId)
            ->whereDate('created_at', now())
            ->count() + 1;

        return sprintf('%s-%d-%s-%04d', $prefix, $outletId, $date, $count);
    }

    /**
     * NOTE: Cek apakah transaksi sudah lunas
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }
}
