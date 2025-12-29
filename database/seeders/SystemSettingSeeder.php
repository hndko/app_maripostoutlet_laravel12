<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * NOTE: Seeder untuk membuat system settings default
     */
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'website_name', 'value' => 'Maripos Outlet', 'type' => 'text', 'group' => 'general'],
            ['key' => 'website_logo', 'value' => null, 'type' => 'image', 'group' => 'general'],
            ['key' => 'website_favicon', 'value' => null, 'type' => 'image', 'group' => 'general'],
            ['key' => 'website_description', 'value' => 'Sistem Point of Sales Modern untuk UMKM Indonesia', 'type' => 'text', 'group' => 'general'],

            // Business
            ['key' => 'currency', 'value' => 'IDR', 'type' => 'text', 'group' => 'business'],
            ['key' => 'currency_symbol', 'value' => 'Rp', 'type' => 'text', 'group' => 'business'],
            ['key' => 'tax_percentage', 'value' => '0', 'type' => 'text', 'group' => 'business'],
            ['key' => 'tax_name', 'value' => 'PPN', 'type' => 'text', 'group' => 'business'],

            // Subscription
            ['key' => 'reminder_days_before', 'value' => '7', 'type' => 'text', 'group' => 'subscription'],
            ['key' => 'trial_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'subscription'],

            // Email
            ['key' => 'email_from_name', 'value' => 'Maripos Outlet', 'type' => 'text', 'group' => 'email'],
            ['key' => 'email_from_address', 'value' => 'noreply@mariposoutlet.com', 'type' => 'text', 'group' => 'email'],
        ];

        foreach ($settings as $setting) {
            SystemSetting::create($setting);
        }
    }
}
