<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel payment_methods untuk metode pembayaran per outlet
     * Types: cash, qris_static, transfer, payment_gateway
     * Relationships:
     * - outlet() : outlet tempat metode pembayaran ini
     * - paymentGateway() : gateway jika type = payment_gateway
     * - transactions() : transaksi yang menggunakan metode ini
     */

    protected $fillable = [
        'outlet_id',
        'type',
        'name',
        'description',
        'payment_gateway_id',
        'config',
        'is_active',
    ];

    protected $casts = [
        'config' => 'array',
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
     * NOTE: Relasi ke payment gateway
     */
    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    /**
     * NOTE: Relasi ke transaksi
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * NOTE: Ambil config tertentu
     */
    public function getConfig(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }
}
