<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel subscriptions untuk langganan user (owner)
     * Status: active, expired, cancelled, pending
     * end_date NULL untuk lifetime
     * Relationships:
     * - owner() : pemilik langganan
     * - package() : paket yang digunakan
     * - payments() : pembayaran untuk langganan ini
     */

    protected $fillable = [
        'owner_id',
        'package_id',
        'status',
        'start_date',
        'end_date',
        'auto_renew',
        'reminder_sent',
        'reminder_sent_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'auto_renew' => 'boolean',
        'reminder_sent' => 'boolean',
        'reminder_sent_at' => 'datetime',
    ];

    /**
     * NOTE: Relasi ke owner
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * NOTE: Relasi ke paket
     */
    public function package()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'package_id');
    }

    /**
     * NOTE: Relasi ke pembayaran
     */
    public function payments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    /**
     * NOTE: Cek apakah subscription masih aktif
     */
    public function isActive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        // Lifetime (end_date = null)
        if ($this->end_date === null) {
            return true;
        }

        return $this->end_date >= now()->toDateString();
    }

    /**
     * NOTE: Cek apakah subscription akan habis dalam N hari
     */
    public function isExpiringSoon(int $days = 7): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        if ($this->end_date === null) {
            return false; // Lifetime
        }

        return $this->end_date <= now()->addDays($days)->toDateString();
    }

    /**
     * NOTE: Cek apakah subscription sudah expired
     */
    public function isExpired(): bool
    {
        if ($this->end_date === null) {
            return false; // Lifetime never expires
        }

        return $this->end_date < now()->toDateString();
    }

    /**
     * NOTE: Hitung sisa hari
     */
    public function remainingDays(): ?int
    {
        if ($this->end_date === null) {
            return null; // Lifetime
        }

        $remaining = now()->diffInDays($this->end_date, false);
        return max(0, $remaining);
    }

    /**
     * NOTE: Buat subscription trial untuk owner baru
     */
    public static function createTrial(int $ownerId): ?self
    {
        $trialPackage = SubscriptionPackage::getTrialPackage();

        if (!$trialPackage) {
            return null;
        }

        return self::create([
            'owner_id' => $ownerId,
            'package_id' => $trialPackage->id,
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addDays($trialPackage->duration_days),
            'auto_renew' => false,
        ]);
    }

    /**
     * NOTE: Ambil limitasi dari paket
     */
    public function getLimit(string $key): ?int
    {
        return match ($key) {
            'outlets' => $this->package->max_outlets,
            'cashiers' => $this->package->max_cashiers,
            'products' => $this->package->max_products,
            default => null,
        };
    }
}
