<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel discounts untuk pengaturan diskon per outlet
     * - type: percentage (%) atau fixed (nominal)
     * - code: kode kupon opsional
     */
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id');
            $table->string('name');
            $table->string('code', 50)->nullable()->unique()->comment('Kode diskon opsional');
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('value', 15, 2)->default(0)->comment('Nilai diskon');
            $table->decimal('min_purchase', 15, 2)->default(0)->comment('Minimal pembelian');
            $table->decimal('max_discount', 15, 2)->nullable()->comment('Maksimal potongan untuk %');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
            $table->index('outlet_id');
            $table->index('code');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
