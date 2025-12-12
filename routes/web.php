<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\UserController;

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
require __DIR__.'/auth.php';

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
    // ##### نهاية الكود المضاف #####
    Route::post('stores/{store}/toggle-status', [StoreController::class, 'toggleStatus'])->name('stores.toggleStatus');
    Route::resource('stores', StoreController::class);
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::resource('users', UserController::class);
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

    // (سنضيف باقي مسارات إدارة البائع هنا لاحقاً)
});