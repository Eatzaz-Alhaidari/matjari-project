<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\AdController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\DiscountController;
use App\Http\Controllers\Api\v1\StoreController;
use App\Http\Controllers\Api\v1\ChatbotController;
use App\Http\Controllers\Api\v1\NotificationController;
use App\Http\Controllers\Api\v1\CustomerController;
use App\Http\Controllers\Api\v1\AddressController;
use App\Http\Controllers\Api\v1\PaymentController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\ActivityController;
use App\Http\Controllers\Api\v1\ReturnController;
use App\Http\Controllers\Api\v1\ReviewController;
use App\Http\Controllers\Api\v1\ComplaintController;
use App\Http\Controllers\Api\v1\SupportController;
use App\Http\Controllers\Api\v1\MessageController;

/*
|--------------------------------------------------------------------------
| API v1 Standard Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // 1-11 المسارات السابقة
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/admin/ads', [AdController::class, 'adminAds']);
    Route::get('/products/top-selling', [ProductController::class, 'topSelling']);
    Route::get('/admin/discounts', [DiscountController::class, 'adminDiscounts']);
    Route::get('/stores', [StoreController::class, 'index']);
    Route::get('/stores/{id}/ads', [StoreController::class, 'ads']);
    Route::get('/stores/{id}/discounts', [StoreController::class, 'discounts']);
    Route::post('/chatbot/responses', [ChatbotController::class, 'storeResponse']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::post('/customers', [CustomerController::class, 'register']);
    
    Route::prefix('auth')->group(function () {
        Route::post('/send-code', [AuthController::class, 'sendCode']);
        Route::post('/verify-code', [AuthController::class, 'verifyCode']);
    });

    /* -------------------------------------------------------------------------- */
    /* التكملة المطلوبة (12-22) */
    /* -------------------------------------------------------------------------- */

    // 12. استقبال عناوين الشحن
    Route::post('/shipping-addresses', [AddressController::class, 'store']);

    // 13. إرسال طرق الدفع
    Route::get('/payment-methods', [PaymentController::class, 'index']);

    // 14. استقبال الطلبات
    Route::post('/orders', [OrderController::class, 'store']);

    // 15. استقبال سجل أنشطة العملاء
    Route::post('/customer-activities', [ActivityController::class, 'store']);

    // 16. استقبال المنتجات المسترجعة
    Route::post('/returns', [ReturnController::class, 'store']);

    // 17. استقبال تقييمات المنتجات
    Route::post('/product-reviews', [ReviewController::class, 'storeProductReview']);

    // 18. استقبال تقييمات المتاجر
    Route::post('/store-reviews', [ReviewController::class, 'storeStoreReview']);

    // 19. استقبال شكاوى العملاء
    Route::post('/complaints', [ComplaintController::class, 'store']);

    // 20. استقبال بيانات الدعم الفني
    Route::post('/support', [SupportController::class, 'store']);

    // 21. استقبال الرسائل الخاصة بالتجار
    Route::post('/messages', [MessageController::class, 'store']);

    // 22. تغيير كلمة المرور للعملاء (محمي بـ Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
    });

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