<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;

class VendorOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorUser = User::has('store')->first();

        if (!$vendorUser || !$vendorUser->store) {
            $this->command->info('No vendor with a store found. Please create a vendor and store first.');
            return;
        }

        $store = $vendorUser->store;
        $products = Product::where('store_id', $store->id)->get();

        if ($products->isEmpty()) {
            $this->command->info('No products found for this store. Please add products first.');
            // Create dummy products if none exist
            $products = Product::factory()->count(3)->create(['store_id' => $store->id]);
        }

        $this->command->info("Seeding 1 order for Store: {$store->name} (ID: {$store->id})");

        // Create 1 order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'user_id' => $vendorUser->id,
            'store_id' => $store->id,
            'total_amount' => 0,
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'shipping_address' => fake()->address(),
            'payment_method' => fake()->randomElement(['cash_on_delivery', 'credit_card']), // Updated to match enum in migration
            'payment_status' => fake()->randomElement(['paid', 'pending']),
            'notes' => fake()->sentence(),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);

        $totalAmount = 0;
        $itemCount = rand(1, 3);

        for ($j = 0; $j < $itemCount; $j++) {
            $product = $products->random();
            $quantity = rand(1, 5);
            $price = $product->price;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);

            $totalAmount += $quantity * $price;
        }

        $order->update(['total_amount' => $totalAmount]);

        $this->command->info('Successfully seeded 1 order.');
    }
}
