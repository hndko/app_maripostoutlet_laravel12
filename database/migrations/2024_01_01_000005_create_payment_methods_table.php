<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel payment_methods untuk metode pembayaran per outlet
     * - type: cash, qris_static, transfer, payment_gateway
     * - config: menyimpan nomor rekening, gambar qris, dll
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id');
            $table->enum('type', ['cash', 'qris_static', 'transfer', 'payment_gateway']);
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('payment_gateway_id')->nullable()->comment('FK jika type=payment_gateway');
            $table->json('config')->nullable()->comment('No rekening, qris image, dll');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
            $table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->onDelete('set null');
            $table->index('outlet_id');
            $table->index('type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
