<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CreateVendorUserSeeder;

try {
    echo "Running RolesAndPermissionsSeeder (Safely)...\n";
    try {
        (new RolesAndPermissionsSeeder())->run();
    } catch (\Exception $e) {
        echo "Note: " . $e->getMessage() . "\n";
    }
    
    echo "Running CategorySeeder...\n";
    (new CategorySeeder())->run();
    
    echo "Running CreateVendorUserSeeder...\n";
    (new CreateVendorUserSeeder())->run();

    echo "\nSUCCESS: Essential seeders completed.";
} catch (\Exception $e) {
    echo "\nERROR: " . $e->getMessage();
}
