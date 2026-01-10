<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ReviewController;//ضمن لي هذه الملف اللي يحتوي على الشعل والدوال

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth API
Route::post('/register', [\App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\API\AuthController::class, 'user']);

    // Complaints API
    Route::get('/complaints', [\App\Http\Controllers\API\ComplaintController::class, 'index']);
    Route::post('/complaints', [\App\Http\Controllers\API\ComplaintController::class, 'store']);
    Route::get('/complaints/{id}', [\App\Http\Controllers\API\ComplaintController::class, 'show']);

    // Protected User Routes can be added here
});

// Reviews API
Route::get('/products/{id}/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']); // Submit a review

// Categories API
Route::get('/categories', [\App\Http\Controllers\API\CategoryController::class, 'index']);

// Products API
Route::get('/products', [\App\Http\Controllers\API\ProductController::class, 'index']);
Route::get('/products/{id}', [\App\Http\Controllers\API\ProductController::class, 'show']);

// Orders API
Route::get('/orders', [\App\Http\Controllers\API\OrderController::class, 'index']);
Route::get('/orders/{id}', [\App\Http\Controllers\API\OrderController::class, 'show']);
Route::post('/orders', [\App\Http\Controllers\API\OrderController::class, 'store']);

// Payment & Wallet API
Route::get('/payment-methods', [\App\Http\Controllers\Api\PaymentController::class, 'getPaymentMethods']);

// Wallet Routes (Protected)
Route::get('/wallet', [\App\Http\Controllers\Api\WalletController::class, 'show']);
// Hint: Order creation with wallet payment logic should be inside OrderController::store or a specific checkpoint in checkout

