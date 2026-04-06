<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    if (!Schema::hasColumn('stores', 'store_number')) {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('store_number')->unique()->after('id')->nullable();
        });
        echo "SUCCESS: Column 'store_number' added to 'stores' table.";
    } else {
        echo "NOTE: Column 'store_number' already exists.";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
