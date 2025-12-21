<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class SampleOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store = Store::first();
        if (! $store) {
            $this->command->info('No store found. Sample order was not created.');
            return;
        }

        $product = Product::where('store_id', $store->id)->first();
        if (! $product) {
            $this->command->info('No product found for the first store. Sample order was not created.');
            return;
        }

        // Pick an existing user different from the store owner, or create one
        $user = User::where('id', '!=', $store->user_id)->first();
        if (! $user) {
            $user = User::factory()->create([
                'name' => 'Sample Customer',
                'email' => 'sample.customer+' . Str::random(5) . '@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Create order
        $order = Order::create([
            'order_number' => 'SAMPLE-' . Str::upper(Str::random(6)),
            'user_id' => $user->id,
            'store_id' => $store->id,
            'total_amount' => $product->price,
            'status' => 'pending',
            'shipping_address' => 'عنوان تجريبي، شارع الاختبار، المدينة',
            'payment_method' => 'cash_on_delivery',
            'payment_status' => 'pending',
            'notes' => 'طلب تجريبي لإنعرض في لوحة البائع',
        ]);

        // Create one order item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
            'total' => $product->price,
        ]);

        $this->command->info('Sample order created with ID: ' . $order->id);
    }
}
