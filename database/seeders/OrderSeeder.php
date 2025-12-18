<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على بائع وعميل تجريبي
        $vendor = User::where('email', 'vendor@example.com')->first();
        $customer = User::where('email', 'customer@example.com')->first();

        if (!$vendor || !$customer) {
            return; // تخطي إذا لم يوجد المستخدمون
        }

        $store = $vendor->store;
        $products = Product::where('store_id', $store->id)->take(3)->get();

        if ($products->isEmpty()) {
            return; // تخطي إذا لم توجد منتجات
        }

        // إنشاء طلب تجريبي
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => $customer->id,
            'store_id' => $store->id,
            'total_amount' => 0, // سيتم حسابه لاحقاً
            'status' => 'pending',
            'shipping_address' => 'الرياض، المملكة العربية السعودية',
            'payment_method' => 'cash_on_delivery',
            'payment_status' => 'pending',
            'notes' => 'طلب تجريبي للاختبار',
        ]);

        $totalAmount = 0;

        // إضافة منتجات للطلب
        foreach ($products as $product) {
            $quantity = rand(1, 3);
            $total = $product->price * $quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'total' => $total,
            ]);

            $totalAmount += $total;
        }

        // تحديث إجمالي الطلب
        $order->update(['total_amount' => $totalAmount]);

        // إنشاء طلب آخر بحالة مختلفة
        $order2 = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => $customer->id,
            'store_id' => $store->id,
            'total_amount' => 0,
            'status' => 'processing',
            'shipping_address' => 'جدة، المملكة العربية السعودية',
            'payment_method' => 'credit_card',
            'payment_status' => 'paid',
        ]);

        $totalAmount2 = 0;
        $sampleProduct = $products->first();

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $sampleProduct->id,
            'quantity' => 2,
            'price' => $sampleProduct->price,
            'total' => $sampleProduct->price * 2,
        ]);

        $totalAmount2 = $sampleProduct->price * 2;
        $order2->update(['total_amount' => $totalAmount2]);
    }
}
