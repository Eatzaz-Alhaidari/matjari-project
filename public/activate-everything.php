<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Store;
use App\Models\Product;
use App\Models\User;

header('Content-Type: application/json');

try {
    // 1. Activate all Stores
    $storesCount = Store::where('is_active', false)->update(['is_active' => true]);
    
    // 2. Activate all Products
    $productsCount = Product::where('status', '!=', 'active')->update(['status' => 'active']);
    
    // 3. Ensure users are active
    $usersCount = User::where('status', '!=', 'active')->update(['status' => 'active']);

    echo json_encode([
        'status' => 'success',
        'message' => 'Everything has been activated!',
        'updated' => [
            'stores' => $storesCount,
            'products' => $productsCount,
            'users' => $usersCount,
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (\Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_PRETTY_PRINT);
}
