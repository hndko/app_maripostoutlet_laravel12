<?php

namespace Database\Seeders;

use App\Models\SubscriptionPackage;
use Illuminate\Database\Seeder;

class SubscriptionPackageSeeder extends Seeder
{
    /**
     * NOTE: Seeder untuk membuat paket langganan default
     * - Trial: 14 hari gratis
     * - Basic: 30 hari
     * - Pro: 30 hari dengan fitur lebih lengkap
     * - Enterprise: 365 hari
     * - Lifetime: Permanen (hanya bisa diaktifkan superadmin)
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Trial',
                'description' => 'Paket trial gratis selama 14 hari untuk mencoba semua fitur dasar.',
                'type' => 'trial',
                'duration_days' => 14,
                'price' => 0,
                'features' => [
                    'POS Basic',
                    'Manajemen Produk',
                    'Laporan Penjualan',
                    'Metode Pembayaran Cash',
                ],
                'max_outlets' => 1,
                'max_cashiers' => 1,
                'max_products' => 50,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 0,
            ],
            [
                'name' => 'Basic',
                'description' => 'Paket dasar untuk UMKM dengan fitur lengkap.',
                'type' => 'duration',
                'duration_days' => 30,
                'price' => 99000,
                'features' => [
                    'POS Lengkap',
                    'Manajemen Produk Unlimited',
                    'Laporan Penjualan',
                    'Semua Metode Pembayaran',
                    'Manajemen Diskon',
                    'Export Data',
                ],
                'max_outlets' => 1,
                'max_cashiers' => 2,
                'max_products' => null, // Unlimited
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Pro',
                'description' => 'Paket profesional untuk bisnis yang berkembang.',
                'type' => 'duration',
                'duration_days' => 30,
                'price' => 199000,
                'features' => [
                    'Semua Fitur Basic',
                    'Multi Outlet',
                    'Multi Kasir',
                    'Payment Gateway Integration',
                    'Laporan Lengkap',
                    'Priority Support',
                ],
                'max_outlets' => 3,
                'max_cashiers' => 5,
                'max_products' => null,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Paket enterprise untuk bisnis besar dengan kebutuhan khusus.',
                'type' => 'duration',
                'duration_days' => 365,
                'price' => 1999000,
                'features' => [
                    'Semua Fitur Pro',
                    'Outlet Unlimited',
                    'Kasir Unlimited',
                    'API Access',
                    'Custom Branding',
                    'Dedicated Support',
                    'SLA 99.9%',
                ],
                'max_outlets' => 999,
                'max_cashiers' => 999,
                'max_products' => null,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Lifetime',
                'description' => 'Paket lifetime dengan akses selamanya. Khusus persetujuan admin.',
                'type' => 'lifetime',
                'duration_days' => null,
                'price' => 4999000,
                'features' => [
                    'Semua Fitur Enterprise',
                    'Akses Selamanya',
                    'Update Gratis Selamanya',
                    'Priority Support Selamanya',
                ],
                'max_outlets' => 999,
                'max_cashiers' => 999,
                'max_products' => null,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($packages as $package) {
            SubscriptionPackage::create($package);
        }
    }
}
