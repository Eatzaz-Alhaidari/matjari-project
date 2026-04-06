<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Store;
use App\Models\Category;

$store = Store::first();
$category = Category::whereNotNull('parent_id')->first() ?: Category::first();

if (!$store || !$category) {
    die("Error: No store or category found to link the product.\n");
}

$product = Product::create([
    'product_code' => 'TEST-001',
    'sku' => 'SKU-TEST-001',
    'name' => 'منتج تجريبي 1',
    'brand' => 'ماركة تجريبية',
    'description' => 'هذا وصف تجريبي للمنتج الاختباري.',
    'full_description' => 'هذا وصف كامل وتفصيلي للمنتج التجريبي الذي تم إنشاؤه لإثبات عمل النظام.',
    'price' => 199.99,
    'cost_price' => 150.00,
    'price_before' => 250.00,
    'stock' => 50,
    'min_stock' => 5,
    'status' => 'active',
    'store_id' => $store->id,
    'category_id' => $category->id,
    'currency' => 'SAR',
    'region' => 'المملكة العربية السعودية'
]);

echo "Product created successfully! ID: {$product->id}\n";
