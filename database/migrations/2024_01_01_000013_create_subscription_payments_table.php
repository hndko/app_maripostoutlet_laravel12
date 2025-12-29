<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel subscription_payments untuk pembayaran langganan
     * - payment_method: manual (transfer) atau payment_gateway
     * - approved_by: superadmin yang approve (untuk manual payment)
     * - gateway_response: menyimpan response JSON dari payment gateway
     */
    public function up(): void
    {
        Schema::create('subscription_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_id');
            $table->string('invoice_number', 100)->unique();
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', ['manual', 'payment_gateway'])->default('manual');
            $table->unsignedBigInteger('payment_gateway_id')->nullable();
            $table->string('gateway_transaction_id')->nullable()->comment('ID transaksi dari gateway');
            $table->json('gateway_response')->nullable()->comment('Response dari gateway');
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->text('notes')->nullable()->comment('Catatan untuk manual payment');
            $table->unsignedBigInteger('approved_by')->nullable()->comment('Superadmin yang approve');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->index('subscription_id');
            $table->index('invoice_number');
            $table->index('status');
            $table->index('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_payments');
    }
};
