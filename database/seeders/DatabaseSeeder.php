<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * NOTE: Main seeder yang menjalankan semua seeder dalam urutan yang benar
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SubscriptionPackageSeeder::class,
            PaymentGatewaySeeder::class,
            SystemSettingSeeder::class,
            SubscriptionSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
