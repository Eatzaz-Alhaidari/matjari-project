<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

header('Content-Type: text/plain');

echo "--- Database Health Check ---\n";

try {
    $dbName = DB::connection()->getDatabaseName();
    echo "Connected to database: $dbName\n\n";

    $tables = DB::select('SHOW TABLES');
    echo "Tables in database:\n";
    foreach ($tables as $table) {
        $tableArray = (array)$table;
        echo "- " . reset($tableArray) . "\n";
    }

    echo "\n--- Role Check ---\n";
    if (Schema::hasTable('roles')) {
        $roles = DB::table('roles')->get();
        echo "Roles found (" . $roles->count() . "):\n";
        foreach ($roles as $role) {
            echo "- ID: {$role->id}, Name: {$role->name}\n";
        }
    } else {
        echo "[!] 'roles' table MISSING!\n";
    }

    echo "\n--- User Count ---\n";
    echo "Total Users: " . DB::table('users')->count() . "\n";

} catch (\Exception $e) {
    echo "[!] ERROR: " . $e->getMessage() . "\n";
}
