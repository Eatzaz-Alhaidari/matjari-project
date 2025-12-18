<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على بائع تجريبي
        $vendor = User::where('email', 'vendor@example.com')->first();

        if (!$vendor) {
            return; // تخطي إذا لم يوجد البائع
        }

        $store = $vendor->store;
        $products = Product::where('store_id', $store->id)->get();

        if ($products->isEmpty()) {
            return; // تخطي إذا لم توجد منتجات
        }

        // تحديث مخزون المنتجات بقيم مختلفة للاختبار
        $stockLevels = [0, 2, 3, 5, 8, 12, 15, 25, 30, 50];

        foreach ($products as $index => $product) {
            $stock = $stockLevels[$index % count($stockLevels)] ?? rand(0, 50);
            $product->update(['stock' => $stock]);
        }
    }
}
