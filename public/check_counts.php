<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

header('Content-Type: application/json');

try {
    $counts = [
        'products_total' => Product::count(),
        'products_active' => Product::where('status', 'active')->count(),
        'product_statuses' => Product::select('status', DB::raw('count(*) as total'))->groupBy('status')->get(),
        'categories_total' => Category::count(),
        'coupons_total' => DB::table('discounts')->count(), // assuming discounts table
    ];
    echo json_encode($counts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
