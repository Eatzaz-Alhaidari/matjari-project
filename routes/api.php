<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\AdvertisementController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ComplaintController;
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\WishlistController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ImageController;
use App\Http\Controllers\Api\SupportSettingsController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\Api\OrderReturnController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\WalletController;

/*
|--------------------------------------------------------------------------
| Public Routes (المسارات العامة)
|--------------------------------------------------------------------------
*/

// التوثيق والتحقق (Auth & OTP)
Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/verify-account', [AuthController::class, 'verifyAccountWithOtp']); // New
Route::post('/password/reset-with-otp', [AuthController::class, 'resetPasswordWithOtp']); // New
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// المتاجر والإعلانات
Route::get('/stores', [StoreController::class, 'index']);
Route::get('/stores/{id}', [StoreController::class, 'show']);
Route::get('/stores/{store}/advertisements', [AdvertisementController::class, 'index']);
Route::get('/advertisements', [AdvertisementController::class, 'index']);

// المنتجات والفئات والتقييمات (للزوار)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/top-selling', [ProductController::class, 'getTopSellingProducts']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/{id}/reviews', [ReviewController::class, 'index']);

// الخدمات العامة والوسائط
Route::get('/settings/support', [SupportSettingsController::class, 'getSettings']);
Route::post('/messages', [StoreController::class, 'submitMessage']); // الشات بوت الذكي
Route::get('/payment-methods', [PaymentController::class, 'getPaymentMethods']);
Route::get('/image/{path}', [ImageController::class, 'show'])->where('path', '.*');

// مسار استقبال تحديث المخزون من برنامج C# (عام)
Route::post('/sync-inventory', [ProductController::class, 'syncFromDesktop']);

/*
|--------------------------------------------------------------------------
| Protected Routes (المسارات المحمية - Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // الملف الشخصي والحساب
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // الشكاوي والعناوين
    Route::get('/complaints', [ComplaintController::class, 'index']);
    Route::post('/complaints', [ComplaintController::class, 'store']);
    Route::get('/complaints/{id}', [ComplaintController::class, 'show']);
    Route::apiResource('addresses', AddressController::class);
    Route::post('/addresses/{address}/default', [AddressController::class, 'setDefault']);

    // المفضلة والتقييمات (للمسجلين)
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);
    Route::post('/reviews', [ReviewController::class, 'store']);

    // إدارة المتاجر (للبائعين / التجار)
    Route::post('/stores', [StoreController::class, 'store']);
    Route::put('/stores/{id}', [StoreController::class, 'update']);
    Route::delete('/stores/{id}', [StoreController::class, 'destroy']);
    Route::post('/stores/{store}/advertisements', [AdvertisementController::class, 'store']);
    Route::get('/vendor/messages', [StoreController::class, 'getVendorMessages']);

    // الطلبات والإرجاع والمحفظة
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/order-returns', [OrderReturnController::class, 'store']);
    Route::get('/wallet', [WalletController::class, 'show']);

    // الإشعارات
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);

    // مزامنة المخزون (النسخة المحمية)
    Route::post('/protected/sync-inventory', [ProductController::class, 'syncFromDesktop']);
});

/*
|--------------------------------------------------------------------------
| Onyx ERP Integration (يمن سوفت)
|--------------------------------------------------------------------------
*/
Route::post('/test-onyx-order', function () {
    return response()->json([
        'message' => 'تم الاتصال التجريبي بنجاح مع جسر أونكس ERP',
        'auth_required' => 'Bearer Token + x-api-key',
        'year' => 2026,
        'sample_body' => [
            'type' => 'SO',
            'storeOrderId' => 'SAKHR-1001',
            'recipientName' => 'Mohammed Ali'
        ]
    ]);
});