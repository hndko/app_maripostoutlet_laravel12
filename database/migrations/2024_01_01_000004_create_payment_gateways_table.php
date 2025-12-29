<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel payment_gateways untuk konfigurasi payment gateway
     * - config: menyimpan api_key, secret_key, dll dalam format JSON
     * - is_sandbox: mode testing
     */
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('midtrans, duitku');
            $table->string('display_name');
            $table->string('logo')->nullable();
            $table->json('config')->nullable()->comment('api_key, secret_key, merchant_code, dll');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_sandbox')->default(false)->comment('Mode sandbox/production');
            $table->timestamps();

            $table->index('name');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
