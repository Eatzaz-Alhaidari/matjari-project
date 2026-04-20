<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "Total Products: " . Product::count() . "\n";
echo "Active Products: " . Product::where('status', 'active')->count() . "\n";
echo "Total Categories: " . Category::count() . "\n";
echo "Active Categories: " . Category::where('status', 'active')->count() . "\n";
