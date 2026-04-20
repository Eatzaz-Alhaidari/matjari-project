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
use App\Http\Controllers\Api\v1\FloosakPaymentController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\ActivityController;
use App\Http\Controllers\Api\v1\ReturnController;
use App\Http\Controllers\Api\v1\ReviewController;
use App\Http\Controllers\Api\v1\ComplaintController;
use App\Http\Controllers\Api\v1\SupportController;
use App\Http\Controllers\Api\v1\MessageController;
use App\Http\Controllers\Api\v1\InventoryController;

/*
|--------------------------------------------------------------------------
| API v1 Standard Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // 1-11 المسارات السابقة المنشئة

    // 1. جلب جميع التصنيفات
    Route::get('/categories', [CategoryController::class, 'index']);

    // 2. جلب إعلانات الأدمن النشطة
    Route::get('/admin/ads', [AdController::class, 'adminAds']);

    // 3. جلب جميع المنتجات
    Route::get('/products', [ProductController::class, 'index']);

    // 4. جلب المنتجات الأكثر طلبًا
    Route::get('/products/top-selling', [ProductController::class, 'topSelling']);

    // تفاصيل المنتج يجب أن تأتي بعد المسارات الثابتة مثل top-selling
    Route::get('/products/{id}', [ProductController::class, 'show']);

    // 4. جلب جميع الخصومات النشطة (أدمن + متاجر)
    Route::get('/discounts', [DiscountController::class, 'index']);

    // 5. جلب خصومات الأدمن
    Route::get('/admin/discounts', [DiscountController::class, 'adminDiscounts']);

    // 5. جلب المتاجر النشطة
    Route::get('/stores', [StoreController::class, 'index']);

    // 6. جلب إعلانات التاجر
    Route::get('/stores/{id}/ads', [StoreController::class, 'ads']);

    // 7. جلب خصومات التاجر
    Route::get('/stores/{id}/discounts', [StoreController::class, 'discounts']);

    // 8. جلب قواعد الشات بوت
    Route::get('/chatbot/rules', [ChatbotController::class, 'rules']);

    // 8. استقبال ردود الشات بوت
    Route::post('/chatbot/responses', [ChatbotController::class, 'storeResponse']);

    // 9. جلب إشعارات مستخدم محدد
    Route::get('/notifications/{user_id}', [NotificationController::class, 'index']);

    // 9. استقبال إشعارات العملاء
    Route::post('/notifications', [NotificationController::class, 'store']);

    // 10. استقبال بيانات العملاء (تسجيل جديد)
    Route::post('/customers', [CustomerController::class, 'register']);
    
    // 11. إرسال وتأكيد رمز التحقق (OTP)
    Route::prefix('auth')->group(function () {
        // إرسال كود التحقق
        Route::post('/send-code', [AuthController::class, 'sendCode']);
        // التأكد من كود التحقق
        Route::post('/verify-code', [AuthController::class, 'verifyCode']);
    });

    /* -------------------------------------------------------------------------- */
    /* التكملة المطلوبة (12-23) */
    /* -------------------------------------------------------------------------- */

    // 12. استقبال عناوين الشحن
    Route::post('/shipping-addresses', [AddressController::class, 'store']);

    // 13. إرسال طرق الدفع
    Route::get('/payment-methods', [PaymentController::class, 'index']);

    // 14. استقبال الطلبات وتتبعها
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

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

    // 22. تغيير كلمة المرور و 23. تسجيل الخروج (محمي بـ Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
        Route::post('/auth/logout', [AuthController::class, 'logout']); // مسار تسجيل الخروج الجديد

        Route::post('/orders/{order}/payments/floosak/initiate', [FloosakPaymentController::class, 'initiate']);
        Route::post('/payments/floosak/{attempt}/confirm', [FloosakPaymentController::class, 'confirm']);
        Route::get('/payments/floosak/{attempt}', [FloosakPaymentController::class, 'show']);
    });

    /* -------------------------------------------------------------------------- */
    /* استعادة تكامل C# (Inventory) */
    /* -------------------------------------------------------------------------- */
    
    // مزامنة المخزون وتحديث الكميات لحظياً (تطبيق C#)
    Route::post('/inventory/sync', [InventoryController::class, 'syncProducts']);

});

// مسار متوافق مع تطبيق السي شارب (Compatibility Route)
Route::post('/sync-inventory', [App\Http\Controllers\Api\v1\InventoryController::class, 'syncProducts']);

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
