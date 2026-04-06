<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $results = DB::select("SHOW COLUMNS FROM stores");
    echo "COLUMNS IN 'stores' (RAW):\n";
    foreach ($results as $column) {
        echo "{$column->Field} - {$column->Type}\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
