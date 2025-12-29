<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * NOTE: Tabel users untuk superadmin, owner, dan kasir
     * Relationships:
     * - owner() : kasir milik owner mana
     * - cashiers() : kasir yang dimiliki owner
     * - outlets() : outlet milik owner
     * - subscriptions() : langganan milik owner
     * - activityLogs() : log aktivitas user
     */

    protected $fillable = [
        'owner_id',
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'role',
        'is_active',
        'sso_provider',
        'sso_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * NOTE: Relasi ke owner (untuk kasir)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * NOTE: Relasi ke kasir-kasir yang dimiliki owner
     */
    public function cashiers()
    {
        return $this->hasMany(User::class, 'owner_id');
    }

    /**
     * NOTE: Relasi ke outlet yang dimiliki owner
     */
    public function outlets()
    {
        return $this->hasMany(Outlet::class, 'owner_id');
    }

    /**
     * NOTE: Relasi ke subscription yang dimiliki owner
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'owner_id');
    }

    /**
     * NOTE: Relasi ke subscription aktif
     */
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class, 'owner_id')
            ->where('status', 'active')
            ->latest();
    }

    /**
     * NOTE: Relasi ke log aktivitas user
     */
    public function activityLogs()
    {
        return $this->hasMany(UserActivityLog::class);
    }

    /**
     * NOTE: Cek apakah user adalah superadmin
     */
    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * NOTE: Cek apakah user adalah owner
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * NOTE: Cek apakah user adalah kasir
     */
    public function isCashier(): bool
    {
        return $this->role === 'kasir';
    }

    /**
     * NOTE: Cek apakah subscription owner masih aktif
     */
    public function hasActiveSubscription(): bool
    {
        if ($this->isSuperadmin()) {
            return true;
        }

        if ($this->isCashier()) {
            return $this->owner?->hasActiveSubscription() ?? false;
        }

        $subscription = $this->activeSubscription;

        if (!$subscription) {
            return false;
        }

        // Lifetime subscription (end_date = null)
        if ($subscription->end_date === null) {
            return true;
        }

        return $subscription->end_date >= now()->toDateString();
    }
}
