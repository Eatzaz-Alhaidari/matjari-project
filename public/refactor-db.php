<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

echo "--- Starting Database Refactor ---\n";

try {
    // 1. Update Categories Table
    if (!Schema::hasColumn('categories', 'is_brand')) {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_brand')->default(false)->after('parent_id');
            $table->string('brand_logo')->nullable()->after('is_brand');
        });
        echo "Added is_brand and brand_logo to categories.\n";
    }

    // 2. Drop Brand Tables
    Schema::dropIfExists('brand_category');
    Schema::dropIfExists('brands');
    echo "Dropped brands and brand_category tables.\n";

    echo "--- Database Refactor Completed Successfully ---\n";

} catch (\Exception $e) {
    echo "[!] ERROR: " . $e->getMessage() . "\n";
}
