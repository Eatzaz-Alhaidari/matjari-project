<?php
// Since we are in public, we need to load Laravel bootstrap
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Store;
use App\Models\Category;

try {
    $store = Store::first();
    $category = Category::whereNotNull('parent_id')->first() ?: Category::first();

    if (!$store || !$category) {
        $storesCount = Store::count();
        $catsCount = Category::count();
        die("Error: No store or category found. Stores: $storesCount, Categories: $catsCount");
    }

    $product = Product::create([
        'product_code' => 'TEST-WEB-' . time(),
        'sku' => 'SKU-WEB-' . time(),
        'name' => 'منتج تجريبي جديد',
        'brand' => 'ماركة تجريبية',
        'description' => 'هذا منتج تمت إضافته عبر كود برمجي اختباري.',
        'full_description' => 'وصف كامل للمنتج التجريبي المضاف حديثاً لرؤية النتيجة في لوحة التحكم.',
        'price' => 299.00,
        'cost_price' => 200.00,
        'price_before' => 350.00,
        'stock' => 100,
        'min_stock' => 10,
        'status' => 'active',
        'store_id' => $store->id,
        'category_id' => $category->id,
        'currency' => 'SAR',
        'region' => 'المملكة العربية السعودية'
    ]);

    echo "SUCCESS: Product created successfully! ID: " . $product->id;
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
