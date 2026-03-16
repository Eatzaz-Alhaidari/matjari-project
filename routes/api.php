<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ReviewController;//ضمن لي هذه الملف اللي يحتوي على الشعل والدوال


// المصادقة
Route::post('/register', [\App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\API\AuthController::class, 'user']);

    // الشكاوي
    Route::get('/complaints', [\App\Http\Controllers\API\ComplaintController::class, 'index']);
    Route::post('/complaints', [\App\Http\Controllers\API\ComplaintController::class, 'store']);
    Route::get('/complaints/{id}', [\App\Http\Controllers\API\ComplaintController::class, 'show']);

    // العناوين
    Route::apiResource('addresses', \App\Http\Controllers\API\AddressController::class);
    Route::post('/addresses/{address}/default', [\App\Http\Controllers\API\AddressController::class, 'setDefault']);

    //
    Route::get('/wishlist', [\App\Http\Controllers\API\WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [\App\Http\Controllers\API\WishlistController::class, 'toggle']);


});

// 
Route::get('/products/{id}/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);

// 
Route::get('/categories', [\App\Http\Controllers\API\CategoryController::class, 'index']);

// 
Route::get('/products', [\App\Http\Controllers\API\ProductController::class, 'index']);
Route::get('/products/{id}', [\App\Http\Controllers\API\ProductController::class, 'show']);

// Image Proxy for CORS
Route::get('/image/{path}', [\App\Http\Controllers\API\ImageController::class, 'show'])->where('path', '.*');

// Advertisements
Route::get('/advertisements', [\App\Http\Controllers\API\AdvertisementController::class, 'index']);

// 
Route::get('/orders', [\App\Http\Controllers\API\OrderController::class, 'index']);
Route::get('/orders/{id}', [\App\Http\Controllers\API\OrderController::class, 'show']);
Route::post('/orders', [\App\Http\Controllers\API\OrderController::class, 'store']);

// 
Route::get('/payment-methods', [\App\Http\Controllers\Api\PaymentController::class, 'getPaymentMethods']);

// Wallet Routes (Protected)
Route::get('/wallet', [\App\Http\Controllers\Api\WalletController::class, 'show']);

// تبع يمن سوفت

// مسار تجريبي (Endpoint) لمحاكاة عملية إرسال طلب إلى نظام أونكس ERP التابع ليمن سوفت
Route::post('/test-onyx-order', function () {

    // إرجاع استجابة بتنسيق JSON لمحاكاة الرد الذي يعيده نظام أونكس عادةً
    return response()->json([
        // رسالة تأكيد بأن الجسر البرمجي (Bridge) بين المتجر والنظام المحاسبي يعمل
        'message' => 'تم الاتصال التجريبي بنجاح',

        // توضيح متطلبات الأمان (Security) المذكورة في وثائق يمن سوفت:
        // - Bearer Token: للتحقق من هوية المستخدم
        // - x-api-key: مفتاح خاص بتطبيقات الطرف الثالث (المتجر)
        'auth_required' => 'Bearer Token + x-api-key',

        // نموذج للبيانات (Sample Body) التي تطلبها أونكس في أوراقها الرسمية:
        'sample_body' => [
            'type' => 'SO',
            'year' => 2026,
            'storeOrderId' => 'WEB-1001',
            'recipientName' => 'Mohammed Ali'
        ]
    ]);
});

// مسار استقبال تحديث المخزون من برنامج C#
Route::post('/sync-inventory', [\App\Http\Controllers\API\ProductController::class, 'syncFromDesktop']);