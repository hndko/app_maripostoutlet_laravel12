<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: Tabel system_settings untuk pengaturan sistem global
     * - type: text, image, boolean, json
     * - group: untuk mengelompokkan settings
     */
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->string('type', 50)->default('text')->comment('text, image, boolean, json');
            $table->string('group', 100)->default('general');
            $table->timestamps();

            $table->index('key');
            $table->index('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
