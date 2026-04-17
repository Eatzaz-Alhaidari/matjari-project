<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    echo "Disabling foreign key checks...\n";
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    echo "Dropping foreign key...\n";
    try {
        DB::statement('ALTER TABLE discounts DROP FOREIGN KEY discounts_store_id_foreign;');
    } catch (\Exception $e) {
        echo "Note: Could not drop FK (maybe it doesn't exist?): " . $e->getMessage() . "\n";
    }

    echo "Modifying column to nullable...\n";
    DB::statement('ALTER TABLE discounts MODIFY store_id bigint unsigned NULL;');

    echo "Re-adding foreign key...\n";
    DB::statement('ALTER TABLE discounts ADD CONSTRAINT discounts_store_id_foreign FOREIGN KEY (store_id) REFERENCES stores (id) ON DELETE CASCADE;');

    echo "Enabling foreign key checks...\n";
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    echo "SUCCESS: discounts table updated!\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
