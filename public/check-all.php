<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

header('Content-Type: application/json');

try {
    $data = [
        'users' => [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
        ],
        'stores' => [
            'total' => Store::count(),
            'active' => Store::where('is_active', true)->count(),
        ],
        'products' => [
            'total' => Product::count(),
            'active' => Product::where('status', 'active')->count(),
        ],
        'categories' => [
            'total' => Category::count(),
        ],
        'sample_active_store' => Store::where('is_active', true)->first(['id', 'name', 'is_active']),
        'sample_active_product' => Product::where('status', 'active')->first(['id', 'name', 'status', 'store_id']),
    ];

    echo json_encode(['status' => 'success', 'data' => $data], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (\Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_PRETTY_PRINT);
}
