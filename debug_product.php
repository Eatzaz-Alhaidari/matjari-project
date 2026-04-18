<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$product = App\Models\Product::with('images')->latest()->first();
header('Content-Type: application/json');
echo json_encode($product ? $product->toArray() : ['error' => 'No products found'], JSON_PRETTY_PRINT);
