<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get vendor user (user with store)
        $user = User::whereHas('store')->first();

        // If no vendor user exists, create a dummy one just for this test
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'بائع تجريبي',
                'email' => 'vendor@example.com',
            ]);
            // Create store for the user
            $user->store()->create([
                'name' => 'متجر تجريبي',
                'slug' => 'test-store',
                'description' => 'متجر تجريبي للخصومات',
                'commercial_registration' => '123456789',
                'address' => 'عنوان تجريبي',
                'is_active' => true,
            ]);
        }

        // Get store from user
        $store = $user->store;
        if (!$store) {
            return; // Skip if no store
        }

        // Get some products for applicable_products
        $products = Product::where('store_id', $store->id)->take(3)->get();

        $discounts = [
            [
                'title' => 'خصم عيد الأم',
                'description' => 'خصم خاص بعيد الأم على جميع المنتجات',
                'code' => 'MOTHERSDAY2024',
                'type' => 'percentage',
                'value' => 15,
                'min_order_amount' => 100,
                'max_discount_amount' => 50,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'usage_limit' => 100,
                'status' => 'active',
                'applicable_products' => $products->pluck('id')->toArray(),
            ],
            [
                'title' => 'خصم ترحيبي',
                'description' => 'خصم للعملاء الجدد',
                'code' => 'WELCOME20',
                'type' => 'fixed',
                'value' => 20,
                'min_order_amount' => 50,
                'max_discount_amount' => null,
                'start_date' => now(),
                'end_date' => now()->addDays(60),
                'usage_limit' => 50,
                'status' => 'active',
                'applicable_products' => [],
            ],
            [
                'title' => 'خصم نهاية الأسبوع',
                'description' => 'خصم خاص بنهاية كل أسبوع',
                'code' => 'WEEKEND10',
                'type' => 'percentage',
                'value' => 10,
                'min_order_amount' => 75,
                'max_discount_amount' => 30,
                'start_date' => now(),
                'end_date' => now()->addDays(7),
                'usage_limit' => null,
                'status' => 'active',
                'applicable_products' => $products->take(2)->pluck('id')->toArray(),
            ],
            [
                'title' => 'خصم منتهي الصلاحية',
                'description' => 'خصم منتهي الصلاحية للاختبار',
                'code' => 'EXPIRED5',
                'type' => 'percentage',
                'value' => 5,
                'min_order_amount' => 0,
                'max_discount_amount' => null,
                'start_date' => now()->subDays(10),
                'end_date' => now()->subDays(1),
                'usage_limit' => 10,
                'status' => 'expired',
                'applicable_products' => [],
            ],
            [
                'title' => 'خصم معطل',
                'description' => 'خصم معطل مؤقتاً',
                'code' => 'DISABLED25',
                'type' => 'fixed',
                'value' => 25,
                'min_order_amount' => 200,
                'max_discount_amount' => null,
                'start_date' => now(),
                'end_date' => now()->addDays(45),
                'usage_limit' => null,
                'status' => 'inactive',
                'applicable_products' => $products->pluck('id')->toArray(),
            ],
        ];

        foreach ($discounts as $data) {
            $discount = Discount::create([
                'store_id' => $store->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'code' => $data['code'],
                'type' => $data['type'],
                'value' => $data['value'],
                'min_order_amount' => $data['min_order_amount'],
                'max_discount_amount' => $data['max_discount_amount'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'usage_limit' => $data['usage_limit'],
                'status' => $data['status'],
            ]);

            // Attach applicable products
            if (!empty($data['applicable_products'])) {
                $discount->applicable_products = $data['applicable_products'];
                $discount->save();
            }
        }
    }
}
