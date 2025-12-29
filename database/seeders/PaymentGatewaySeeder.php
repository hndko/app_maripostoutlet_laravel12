<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * NOTE: Seeder untuk membuat payment gateway default
     * - Midtrans
     * - Duitku
     */
    public function run(): void
    {
        $gateways = [
            [
                'name' => 'midtrans',
                'display_name' => 'Midtrans',
                'logo' => null,
                'config' => [
                    'merchant_id' => '',
                    'client_key' => '',
                    'server_key' => '',
                ],
                'is_active' => false,
                'is_sandbox' => true,
            ],
            [
                'name' => 'duitku',
                'display_name' => 'Duitku',
                'logo' => null,
                'config' => [
                    'merchant_code' => '',
                    'api_key' => '',
                    'callback_url' => '',
                ],
                'is_active' => false,
                'is_sandbox' => true,
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::create($gateway);
        }
    }
}
