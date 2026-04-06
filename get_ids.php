<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Store;
use App\Models\Category;

echo "STORES:\n";
foreach (Store::all() as $s) { echo "{$s->id}: {$s->name}\n"; }
echo "\nCATEGORIES:\n";
foreach (Category::all() as $c) { echo "{$c->id}: {$c->name}\n"; }
