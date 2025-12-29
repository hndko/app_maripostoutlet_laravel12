<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * NOTE: Seeder untuk membuat data demo (outlet, kategori, produk, metode pembayaran)
     */
    public function run(): void
    {
        $owner = User::where('role', 'owner')->first();

        if (!$owner) {
            return;
        }

        // Create demo outlet
        $outlet = Outlet::create([
            'owner_id' => $owner->id,
            'name' => 'Outlet Demo',
            'address' => 'Jl. Demo No. 123, Jakarta',
            'phone' => '021-1234567',
            'is_active' => true,
        ]);

        // Create categories
        $categories = [
            ['name' => 'Makanan', 'description' => 'Berbagai jenis makanan', 'sort_order' => 1],
            ['name' => 'Minuman', 'description' => 'Berbagai jenis minuman', 'sort_order' => 2],
            ['name' => 'Snack', 'description' => 'Camilan dan snack', 'sort_order' => 3],
        ];

        $createdCategories = [];
        foreach ($categories as $category) {
            $createdCategories[] = ProductCategory::create([
                'outlet_id' => $outlet->id,
                'name' => $category['name'],
                'description' => $category['description'],
                'sort_order' => $category['sort_order'],
                'is_active' => true,
            ]);
        }

        // Create products
        $products = [
            // Makanan
            ['category_index' => 0, 'name' => 'Nasi Goreng Spesial', 'price' => 25000, 'cost_price' => 15000],
            ['category_index' => 0, 'name' => 'Mie Goreng', 'price' => 20000, 'cost_price' => 12000],
            ['category_index' => 0, 'name' => 'Ayam Goreng', 'price' => 18000, 'cost_price' => 10000],
            // Minuman
            ['category_index' => 1, 'name' => 'Es Teh Manis', 'price' => 5000, 'cost_price' => 2000],
            ['category_index' => 1, 'name' => 'Es Jeruk', 'price' => 7000, 'cost_price' => 3000],
            ['category_index' => 1, 'name' => 'Kopi Susu', 'price' => 15000, 'cost_price' => 7000],
            // Snack
            ['category_index' => 2, 'name' => 'Kentang Goreng', 'price' => 15000, 'cost_price' => 8000],
            ['category_index' => 2, 'name' => 'Pisang Goreng', 'price' => 10000, 'cost_price' => 5000],
        ];

        foreach ($products as $index => $product) {
            Product::create([
                'outlet_id' => $outlet->id,
                'category_id' => $createdCategories[$product['category_index']]->id,
                'sku' => 'SKU-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'name' => $product['name'],
                'price' => $product['price'],
                'cost_price' => $product['cost_price'],
                'use_stock' => false,
                'stock' => 0,
                'is_active' => true,
            ]);
        }

        // Create payment methods
        $paymentMethods = [
            [
                'type' => 'cash',
                'name' => 'Tunai',
                'description' => 'Pembayaran tunai',
            ],
            [
                'type' => 'qris_static',
                'name' => 'QRIS',
                'description' => 'Scan QRIS untuk pembayaran',
                'config' => ['qris_image' => null],
            ],
            [
                'type' => 'transfer',
                'name' => 'Transfer Bank BCA',
                'description' => 'Transfer ke rekening BCA',
                'config' => [
                    'bank_name' => 'BCA',
                    'account_number' => '1234567890',
                    'account_name' => 'Demo Owner',
                ],
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create([
                'outlet_id' => $outlet->id,
                'type' => $method['type'],
                'name' => $method['name'],
                'description' => $method['description'],
                'config' => $method['config'] ?? null,
                'is_active' => true,
            ]);
        }
    }
}
