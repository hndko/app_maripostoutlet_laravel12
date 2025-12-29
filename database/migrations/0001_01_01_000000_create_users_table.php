<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel users untuk superadmin, owner, dan kasir
     * - owner_id digunakan untuk kasir (menunjuk ke owner-nya)
     * - role: superadmin, owner, kasir
     * - SSO mendukung login dengan provider eksternal
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id')->nullable()->comment('FK ke users untuk kasir');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->string('avatar')->nullable();
            $table->enum('role', ['superadmin', 'owner', 'kasir'])->default('owner');
            $table->boolean('is_active')->default(true);
            $table->string('sso_provider', 50)->nullable()->comment('google, facebook, dll');
            $table->string('sso_id')->nullable()->comment('ID dari SSO provider');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('role');
            $table->index('is_active');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
