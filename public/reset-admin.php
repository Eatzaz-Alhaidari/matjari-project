<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

// تسجيل الدخول لـ Laravel يدوياً
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h1>Laravel Admin Reset Utility</h1>";

try {
    // التأكد من وجود الأدوار أولاً
    if (!Role::where('name', 'super-admin')->exists()) {
        Role::create(['name' => 'super-admin']);
        echo "<p>[+] Role 'super-admin' created.</p>";
    }
    
    if (!Role::where('name', 'vendor')->exists()) {
        Role::create(['name' => 'vendor']);
        echo "<p>[+] Role 'vendor' created.</p>";
    }

    // استخدام updateOrCreate بدلاً من حذف المستخدم لتجنب أخطاء الربط (Foreign Key)
    $user = User::updateOrCreate(
        ['email' => 'superadmin@example.com'],
        [
            'name' => 'Super Admin',
            'password' => 'password', // سيقوم المودل بتشفيرها تلقائياً
            'status' => 'active'
        ]
    );

    $user->assignRole('super-admin');

    echo "<p style='color: green; font-weight: bold;'>[SUCCESS] Admin user updated/created and role assigned!</p>";
    echo "<ul>
            <li>Email: superadmin@example.com</li>
            <li>Password: password</li>
          </ul>";
    echo "<p><a href='/login'>Go to Login Page</a></p>";

} catch (\Exception $e) {
    echo "<p style='color: red;'>[ERROR] " . $e->getMessage() . "</p>";
}
