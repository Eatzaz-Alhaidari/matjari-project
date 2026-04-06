<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

echo "Checking tables...\n";
echo "product_sizes: " . (Schema::hasTable('product_sizes') ? 'EXISTS' : 'MISSING') . "\n";
echo "product_colors: " . (Schema::hasTable('product_colors') ? 'EXISTS' : 'MISSING') . "\n";
