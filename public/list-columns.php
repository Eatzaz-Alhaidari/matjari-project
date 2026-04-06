<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

try {
    $columns = Schema::getColumnListing('stores');
    echo "COLUMNS IN 'stores':\n";
    print_r($columns);
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
