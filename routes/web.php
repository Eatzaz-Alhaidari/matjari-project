<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ==================== Public Routes ====================

// الصفحة الرئيسية للمتجر (واجهة العميل)
Route::get('/', function () {
    return view('welcome');
});

// مسارات المصادقة (تسجيل دخول، تسجيل، ... الخ)
// هذا الملف يحتوي على كل المسارات مثل /login, /register, /logout
require __DIR__ . '/auth.php';

// ==================== Admin Routes ====================
Route::prefix('admin')
    ->middleware(['auth', 'role:super-admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::post('vendors/{vendor}/toggle-status', [VendorController::class, 'toggleStatus'])->name('vendors.toggleStatus');
        Route::resource('vendors', VendorController::class);

        // ##### الكود المضاف #####
        Route::resource('stores', StoreController::class);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::patch('products/{product}/toggle-status', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
        // ##### نهاية الكود المضاف #####
        Route::post('stores/{store}/toggle-status', [StoreController::class, 'toggleStatus'])->name('stores.toggleStatus');
        Route::resource('stores', StoreController::class);
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::resource('users', UserController::class);

        // Wallets
        Route::get('wallets', [\App\Http\Controllers\Admin\WalletController::class, 'index'])->name('wallets.index');

        // Financial Reports
        Route::get('reports/financial', [\App\Http\Controllers\Admin\FinancialReportController::class, 'index'])->name('reports.financial');

        // Reviews
        Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');

        // Notifications
        Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');

        // Complaints
        Route::get('complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'index'])->name('complaints.index');

        // TEST NOTIFICATION ROUTE (Temporary)
        Route::get('/test-notification', function () {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user) {
                $user->notify(new \App\Notifications\TestNotification('تجربة إشعار جديد في ' . now()->toTimeString()));
                return 'تم إرسال الإشعار بنجاح! اذهب الآن لصفحة الإشعارات لرؤيته.';
            }
            return 'يجب تسجيل الدخول أولاً.';
        });
    });

// ==================== Protected Routes ====================

// --- مجموعة مسارات الأدمن ---
Route::prefix('admin')
    ->middleware(['auth', 'role:super-admin'])
    ->name('admin.')
    ->group(function () {

        // لوحة تحكم الأدمن الرئيسية
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // المسار الخاص بتغيير حالة المتجر
        Route::post('vendors/{vendor}/toggle-status', [VendorController::class, 'toggleStatus'])->name('vendors.toggleStatus');

        // المسارات الخاصة بإدارة البائعين (CRUD)
        Route::resource('vendors', VendorController::class);

        // (سنضيف باقي مسارات إدارة الأدمن هنا لاحقاً)
    });


// --- مجموعة مسارات البائع ---
Route::prefix('vendor')
    ->middleware(['auth', 'role:vendor'])
    ->name('vendor.')
    ->group(function () {

        // لوحة تحكم البائع الرئيسية
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

        // إدارة المنتجات
        Route::resource('products', \App\Http\Controllers\Vendor\ProductController::class);
        Route::patch('products/{product}/toggle-status', [\App\Http\Controllers\Vendor\ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

        // إدارة الطلبات
        Route::resource('orders', \App\Http\Controllers\Vendor\OrderController::class)->except(['create', 'store', 'edit', 'destroy']);

        // إدارة المخازن
        Route::get('warehouse/import', [\App\Http\Controllers\Vendor\WarehouseController::class, 'import'])->name('warehouse.import');
        Route::post('warehouse/import', [\App\Http\Controllers\Vendor\WarehouseController::class, 'processImport'])->name('warehouse.process-import');
        Route::get('warehouse', [\App\Http\Controllers\Vendor\WarehouseController::class, 'index'])->name('warehouse.index');
        Route::patch('warehouse/products/{product}/stock', [\App\Http\Controllers\Vendor\WarehouseController::class, 'updateStock'])->name('warehouse.updateStock');

        // إدارة الإعلانات
        Route::resource('advertisements', \App\Http\Controllers\Vendor\AdvertisementController::class);
        Route::patch('advertisements/{advertisement}/toggle-status', [\App\Http\Controllers\Vendor\AdvertisementController::class, 'toggleStatus'])->name('advertisements.toggleStatus');

        // إدارة الخصومات
        Route::resource('discounts', \App\Http\Controllers\Vendor\DiscountController::class);
        Route::patch('discounts/{discount}/toggle-status', [\App\Http\Controllers\Vendor\DiscountController::class, 'toggleStatus'])->name('discounts.toggleStatus');

        // إعدادات المتجر
        Route::get('store/edit', [\App\Http\Controllers\Vendor\DashboardController::class, 'editStore'])->name('store.edit');
        Route::put('store/update', [\App\Http\Controllers\Vendor\DashboardController::class, 'updateStore'])->name('store.update');

        // إدارة المبيعات
        Route::get('sales', [\App\Http\Controllers\Vendor\SalesController::class, 'index'])->name('sales.index');
        Route::get('sales/export', [\App\Http\Controllers\Vendor\SalesController::class, 'export'])->name('sales.export');

        // إدارة التقييمات
        Route::get('reviews', [\App\Http\Controllers\Vendor\ReviewController::class, 'index'])->name('reviews.index');
        Route::get('reviews/{review}', [\App\Http\Controllers\Vendor\ReviewController::class, 'show'])->name('reviews.show');
        Route::patch('reviews/{review}/update-status', [\App\Http\Controllers\Vendor\ReviewController::class, 'updateStatus'])->name('reviews.updateStatus');

        // المنتجات الأكثر طلباً
        Route::get('top-products', [\App\Http\Controllers\Vendor\TopProductsController::class, 'index'])->name('top-products.index');

        // التقارير المالية
        Route::get('financial-reports', [\App\Http\Controllers\Vendor\FinancialReportController::class, 'index'])->name('financial-reports.index');

        // (سنضيف باقي مسارات إدارة البائع هنا لاحقاً)
    });