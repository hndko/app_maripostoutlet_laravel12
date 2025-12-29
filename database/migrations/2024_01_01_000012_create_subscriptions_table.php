<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel subscriptions untuk langganan user (owner)
     * - status: active, expired, cancelled, pending
     * - end_date NULL untuk lifetime
     * - reminder_sent: flag untuk cek apakah reminder sudah dikirim
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('package_id');
            $table->enum('status', ['active', 'expired', 'cancelled', 'pending'])->default('pending');
            $table->date('start_date');
            $table->date('end_date')->nullable()->comment('NULL untuk lifetime');
            $table->boolean('auto_renew')->default(false);
            $table->boolean('reminder_sent')->default(false);
            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('subscription_packages')->onDelete('cascade');
            $table->index('owner_id');
            $table->index('package_id');
            $table->index('status');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
