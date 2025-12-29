<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel payment_gateways untuk konfigurasi payment gateway (Midtrans, Duitku)
     * Relationships:
     * - paymentMethods() : metode pembayaran yang menggunakan gateway ini
     * - subscriptionPayments() : pembayaran subscription yang menggunakan gateway ini
     */

    protected $fillable = [
        'name',
        'display_name',
        'logo',
        'config',
        'is_active',
        'is_sandbox',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
        'is_sandbox' => 'boolean',
    ];

    /**
     * NOTE: Sembunyikan config dari serialization untuk keamanan
     */
    protected $hidden = [
        'config',
    ];

    /**
     * NOTE: Relasi ke metode pembayaran
     */
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    /**
     * NOTE: Relasi ke pembayaran subscription
     */
    public function subscriptionPayments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    /**
     * NOTE: Ambil config tertentu
     */
    public function getConfig(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }
}
