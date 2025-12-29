<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel user_activity_logs untuk mencatat aktivitas user
     * - action: login, logout, create, update, delete, dll
     * - old_data dan new_data: untuk menyimpan perubahan data
     */
    public function up(): void
    {
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action', 100)->comment('login, logout, create, update, delete');
            $table->string('module', 100)->comment('Modul yang diakses');
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('old_data')->nullable()->comment('Data sebelum perubahan');
            $table->json('new_data')->nullable()->comment('Data setelah perubahan');
            $table->timestamp('created_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('user_id');
            $table->index('action');
            $table->index('module');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activity_logs');
    }
};
