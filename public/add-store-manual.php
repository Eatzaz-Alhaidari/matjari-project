<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;

try {
    $user = User::where('email', 'vendor@app.com')->first();
    if (!$user) {
        $user = User::create([
            'name' => 'Test Vendor',
            'email' => 'vendor@app.com',
            'password' => bcrypt('password'),
            'status' => 'active'
        ]);
    }

    $id = DB::table('stores')->insertGetId([
        'user_id' => $user->id,
        'name' => 'Manual Test Store',
        'slug' => 'manual-test-store-' . time(),
        'description' => 'Manual description',
        'is_active' => 1,
        'store_number' => 'STR-MANUAL-' . time(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    echo "SUCCESS: Store created manually! ID: " . $id;
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
