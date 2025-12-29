<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel transactions untuk menyimpan transaksi penjualan
     * - payment_status: pending, paid, failed, refunded
     * - payment_reference: ID referensi dari payment gateway
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id');
            $table->unsignedBigInteger('cashier_id')->comment('User yang melakukan transaksi');
            $table->string('invoice_number', 50)->unique();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->unsignedBigInteger('payment_method_id');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_reference')->nullable()->comment('Referensi dari gateway');
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('change_amount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->string('customer_name')->nullable();
            $table->timestamps();

            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->index('outlet_id');
            $table->index('cashier_id');
            $table->index('invoice_number');
            $table->index('payment_status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
