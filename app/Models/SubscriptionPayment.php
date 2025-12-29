<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    use HasFactory;

    /**
     * NOTE: Tabel subscription_payments untuk pembayaran langganan
     * Payment Method: manual (transfer), payment_gateway
     * Status: pending, paid, failed, expired, refunded
     * Relationships:
     * - subscription() : langganan yang dibayar
     * - paymentGateway() : gateway jika menggunakan payment gateway
     * - approvedBy() : superadmin yang approve (untuk manual)
     */

    protected $fillable = [
        'subscription_id',
        'invoice_number',
        'amount',
        'payment_method',
        'payment_gateway_id',
        'gateway_transaction_id',
        'gateway_response',
        'status',
        'paid_at',
        'expired_at',
        'notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * NOTE: Relasi ke subscription
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * NOTE: Relasi ke payment gateway
     */
    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    /**
     * NOTE: Relasi ke admin yang approve
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * NOTE: Generate invoice number
     */
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'SUB';
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now())->count() + 1;

        return sprintf('%s-%s-%04d', $prefix, $date, $count);
    }

    /**
     * NOTE: Cek apakah pembayaran sudah lunas
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * NOTE: Cek apakah pembayaran pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * NOTE: Approve pembayaran manual
     */
    public function approve(int $adminId): bool
    {
        $this->status = 'paid';
        $this->paid_at = now();
        $this->approved_by = $adminId;
        $this->approved_at = now();

        if ($this->save()) {
            // Aktifkan subscription
            $subscription = $this->subscription;
            $subscription->status = 'active';

            // Jika ada durasi, hitung end_date
            $package = $subscription->package;
            if ($package->duration_days) {
                $startDate = $subscription->end_date && $subscription->end_date > now()
                    ? $subscription->end_date
                    : now();
                $subscription->end_date = $startDate->addDays($package->duration_days);
            } else {
                // Lifetime
                $subscription->end_date = null;
            }

            return $subscription->save();
        }

        return false;
    }

    /**
     * NOTE: Reject pembayaran manual
     */
    public function reject(int $adminId, string $reason): bool
    {
        $this->status = 'failed';
        $this->notes = $reason;
        $this->approved_by = $adminId;
        $this->approved_at = now();

        return $this->save();
    }
}
