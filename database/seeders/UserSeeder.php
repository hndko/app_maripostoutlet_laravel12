<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'email' => 'superadmin@mariposoutlet.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'superadmin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Owner Demo
        $owner = User::create([
            'name' => 'Demo Owner',
            'email' => 'owner@mariposoutlet.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'role' => 'owner',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Kasir Demo (milik owner demo)
        User::create([
            'owner_id' => $owner->id,
            'name' => 'Demo Kasir',
            'email' => 'kasir@mariposoutlet.com',
            'password' => Hash::make('password'),
            'phone' => '081234567892',
            'role' => 'kasir',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
