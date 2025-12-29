<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel products untuk menyimpan data produk
     * - use_stock: jika true maka stok akan dihitung
     * - min_stock: untuk alert stok minimum
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id');
            $table->unsignedBigInteger('category_id');
            $table->string('sku', 100)->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('cost_price', 15, 2)->nullable()->comment('Harga modal');
            $table->boolean('use_stock')->default(false);
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(0)->comment('Stok minimum untuk alert');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->index('outlet_id');
            $table->index('category_id');
            $table->index('is_active');
            $table->index('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
