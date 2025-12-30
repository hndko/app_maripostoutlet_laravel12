<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * NOTE: Seeder untuk membuat user default
     * - 1 Superadmin
     * - 1 Owner demo dengan subscription trial
     * - 1 Kasir demo
     */
    public function run(): void
    {
        // Superadmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => 'password',
            'phone' => '081234567890',
            'role' => 'superadmin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Owner Demo
        $owner = User::create([
            'name' => 'Demo Owner',
            'email' => 'owner@example.com',
            'password' => 'password',
            'phone' => '081234567891',
            'role' => 'owner',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Kasir Demo (milik owner demo)
        User::create([
            'owner_id' => $owner->id,
            'name' => 'Demo Kasir',
            'email' => 'kasir@example.com',
            'password' => 'password',
            'phone' => '081234567892',
            'role' => 'kasir',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
