<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;

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

// مسارات المصادقة
require __DIR__ . '/auth.php';

// ==================== Admin Routes ====================
Route::prefix('admin')
    ->middleware(['auth', 'role:super-admin'])
    ->name('admin.')
    ->group(function () {

        // 1. Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

        // 2. Vendors Management
        Route::post('vendors/{vendor}/toggle-status', [VendorController::class, 'toggleStatus'])->name('vendors.toggleStatus');
        Route::post('vendors/{vendor}/ban', [VendorController::class, 'ban'])->name('vendors.ban');
        Route::post('vendors/{vendor}/activate', [VendorController::class, 'activate'])->name('vendors.activate');
        Route::resource('vendors', VendorController::class);

        // 3. Stores Management
        Route::post('stores/{store}/toggle-status', [StoreController::class, 'toggleStatus'])->name('stores.toggleStatus');
        Route::resource('stores', StoreController::class);

        // 4. Products Management
        // Use ['as' => 'admin'] to prefix resource route names with 'admin.' properly if needed,
        // but since we are wrapped in name('admin.'), a simple resource usually suffices.
        // However, let's correspond to previous fixes to ensure 'admin.products.index' exists.
        Route::resource('products', ProductController::class);
        Route::patch('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

        // 5. Orders Management
        Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');

        // 6. Returns Management (New)
        Route::get('returns', [\App\Http\Controllers\Admin\OrderReturnController::class, 'index'])->name('returns.index');
        Route::patch('returns/{returnOrder}', [\App\Http\Controllers\Admin\OrderReturnController::class, 'updateStatus'])->name('returns.updateStatus');
        Route::patch('returns/{returnOrder}/restock', [\App\Http\Controllers\Admin\OrderReturnController::class, 'restock'])->name('returns.restock');

        // 6.2 Shipping Management (New Demo)
        Route::get('shipping', [\App\Http\Controllers\Admin\ShippingController::class, 'index'])->name('shipping.index');
        Route::post('shipping', [\App\Http\Controllers\Admin\ShippingController::class, 'store'])->name('shipping.store');
        Route::patch('shipping/{shipping}/update-status', [\App\Http\Controllers\Admin\ShippingController::class, 'updateStatus'])->name('shipping.updateStatus');

        // 7. Users (Customers) Management
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::resource('users', UserController::class);

        // 7. Wallets
        Route::get('wallets', [\App\Http\Controllers\Admin\WalletController::class, 'index'])->name('wallets.index');

        // 8. Financial Reports
        Route::get('reports/financial', [\App\Http\Controllers\Admin\FinancialReportController::class, 'index'])->name('reports.financial');

        // 9. Reviews
        Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/update-status', [\App\Http\Controllers\Admin\ReviewController::class, 'updateStatus'])->name('reviews.updateStatus');

        // 10. Notifications
        Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');

        // 11. Complaints
        Route::get('complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'index'])->name('complaints.index');

        // Platform Settings
        Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class)->only(['index', 'store']);

        // Activity Logs
        Route::get('activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');

        // Coming Soon (Temporary for new features)
        Route::get('coming-soon', function () {
            return view('admin.coming-soon');
        })->name('coming-soon');

        // Test Route
        Route::get('/test-notification', function () {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user) {
                $user->notify(new \App\Notifications\TestNotification('تجربة إشعار جديد في ' . now()->toTimeString()));
                return 'تم إرسال الإشعار بنجاح!';
            }
            return 'يجب تسجيل الدخول أولاً.';
        });
    });


// ==================== Vendor Routes ====================
Route::prefix('vendor')
    ->middleware(['auth', 'role:vendor'])
    ->name('vendor.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Vendor\DashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::resource('products', \App\Http\Controllers\Vendor\ProductController::class);
        Route::patch('products/{product}/toggle-status', [\App\Http\Controllers\Vendor\ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

        // Orders
        Route::resource('orders', \App\Http\Controllers\Vendor\OrderController::class)->except(['edit', 'destroy']);
        Route::get('orders/create', [\App\Http\Controllers\Vendor\OrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [\App\Http\Controllers\Vendor\OrderController::class, 'store'])->name('orders.store');

        // Warehouse
        Route::get('warehouse/import', [\App\Http\Controllers\Vendor\WarehouseController::class, 'import'])->name('warehouse.import');
        Route::post('warehouse/import', [\App\Http\Controllers\Vendor\WarehouseController::class, 'processImport'])->name('warehouse.process-import');
        Route::get('warehouse', [\App\Http\Controllers\Vendor\WarehouseController::class, 'index'])->name('warehouse.index');
        Route::patch('warehouse/products/{product}/stock', [\App\Http\Controllers\Vendor\WarehouseController::class, 'updateStock'])->name('warehouse.updateStock');

        // Advertisements
        Route::resource('advertisements', \App\Http\Controllers\Vendor\AdvertisementController::class);
        Route::patch('advertisements/{advertisement}/toggle-status', [\App\Http\Controllers\Vendor\AdvertisementController::class, 'toggleStatus'])->name('advertisements.toggleStatus');

        // Discounts
        Route::resource('discounts', \App\Http\Controllers\Vendor\DiscountController::class);
        Route::patch('discounts/{discount}/toggle-status', [\App\Http\Controllers\Vendor\DiscountController::class, 'toggleStatus'])->name('discounts.toggleStatus');

        // Store Settings
        Route::get('store/edit', [\App\Http\Controllers\Vendor\DashboardController::class, 'editStore'])->name('store.edit');
        Route::put('store/update', [\App\Http\Controllers\Vendor\DashboardController::class, 'updateStore'])->name('store.update');

        // Sales
        Route::get('sales', [\App\Http\Controllers\Vendor\SalesController::class, 'index'])->name('sales.index');
        Route::get('sales/export', [\App\Http\Controllers\Vendor\SalesController::class, 'export'])->name('sales.export');

        // Reviews
        Route::get('reviews', [\App\Http\Controllers\Vendor\ReviewController::class, 'index'])->name('reviews.index');
        Route::get('reviews/{review}', [\App\Http\Controllers\Vendor\ReviewController::class, 'show'])->name('reviews.show');
        Route::patch('reviews/{review}/update-status', [\App\Http\Controllers\Vendor\ReviewController::class, 'updateStatus'])->name('reviews.updateStatus');

        // Top Products
        Route::get('top-products', [\App\Http\Controllers\Vendor\TopProductsController::class, 'index'])->name('top-products.index');

        // Financial Reports
        Route::get('financial-reports', [\App\Http\Controllers\Vendor\FinancialReportController::class, 'index'])->name('financial-reports.index');

        // Shipping Info (New)
        Route::get('shipping-info', [\App\Http\Controllers\Vendor\ShippingController::class, 'index'])->name('shipping.index');
    });