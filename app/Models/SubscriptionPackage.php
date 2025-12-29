<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel subscription_packages untuk paket langganan
     * Types: trial (14 hari), duration (7, 30, 365 hari), lifetime (permanen)
     * Relationships:
     * - subscriptions() : langganan yang menggunakan paket ini
     */

    protected $fillable = [
        'name',
        'description',
        'type',
        'duration_days',
        'price',
        'features',
        'max_outlets',
        'max_cashiers',
        'max_products',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'duration_days' => 'integer',
        'price' => 'decimal:2',
        'features' => 'array',
        'max_outlets' => 'integer',
        'max_cashiers' => 'integer',
        'max_products' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * NOTE: Relasi ke langganan
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'package_id');
    }

    /**
     * NOTE: Cek apakah paket lifetime
     */
    public function isLifetime(): bool
    {
        return $this->type === 'lifetime';
    }

    /**
     * NOTE: Cek apakah paket trial
     */
    public function isTrial(): bool
    {
        return $this->type === 'trial';
    }

    /**
     * NOTE: Ambil paket trial default
     */
    public static function getTrialPackage(): ?self
    {
        return self::where('type', 'trial')
            ->where('is_active', true)
            ->first();
    }

    /**
     * NOTE: Ambil semua paket aktif yang bisa dipilih
     */
    public static function getAvailablePackages()
    {
        return self::where('is_active', true)
            ->where('type', '!=', 'trial')
            ->orderBy('sort_order')
            ->orderBy('price')
            ->get();
    }
}
