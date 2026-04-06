<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Store;
use App\Models\Category;

echo "STORES COUNT: " . Store::count() . "\n";
echo "CATEGORIES COUNT: " . Category::count() . "\n";

if (Category::count() == 0) {
    echo "Seeding categories...\n";
    (new Database\Seeders\CategorySeeder())->run();
    echo "CATEGORIES COUNT AFTER SEED: " . Category::count() . "\n";
}
