<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel subscription_packages untuk paket langganan
     * - type: trial (14 hari), duration (7, 30, 365 hari), lifetime (permanen)
     * - features: JSON berisi fitur yang tersedia
     * - max_outlets, max_cashiers, max_products: limitasi fitur
     */
    public function up(): void
    {
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['trial', 'duration', 'lifetime'])->default('duration');
            $table->integer('duration_days')->nullable()->comment('Durasi dalam hari, NULL untuk lifetime');
            $table->decimal('price', 15, 2)->default(0);
            $table->json('features')->nullable()->comment('Fitur yang termasuk');
            $table->integer('max_outlets')->default(1);
            $table->integer('max_cashiers')->default(1)->comment('Per outlet');
            $table->integer('max_products')->nullable()->comment('NULL = unlimited');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false)->comment('Paket unggulan');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_packages');
    }
};
