<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use App\Models\Category; // Ensure you have a Category model
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // We need at least one store to attach products to
        $store = Store::first();

        // If no store exists, create one (and a vendor user if needed, but let's assume we can create a store for a random user if store doesn't exist, OR just skip if truly empty setup).
        // For simplicity, if no store, we create one linked to first user.
        if (!$store) {
            $user = \App\Models\User::first();
            if ($user) {
                $store = Store::create([
                    'user_id' => $user->id,
                    'name' => 'متجر افتراضي',
                    'slug' => 'default-store',
                    'description' => 'وصف المتجر الافتراضي',
                    'is_active' => true,
                ]);
            } else {
                return; // No users to own a store
            }
        }

        // Check/Create a category
        $category = Category::first();
        if (!$category) {
            $category = Category::create([
                'name' => 'إلكترونيات عامة',
            ]);
        }

        // Create 10 dummy products
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'store_id' => $store->id,
                'category_id' => $category->id,
                'name_ar' => 'منتج تجريبي ' . ($i + 1),
                'name_en' => 'Test Product ' . ($i + 1),
                'slug' => 'test-product-' . ($i + 1) . '-' . Str::random(5),
                'description_ar' => 'وصف تجريبي للمنتج رقم ' . ($i + 1),
                'description_en' => 'Test description for product ' . ($i + 1),
                'price' => rand(10, 500),
                'stock' => rand(0, 100),
                'is_active' => true,
            ]);
        }
    }
}
