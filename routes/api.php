<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [App\Http\Controllers\Api\ProductController::class, 'index']);
Route::get('/products/{id}', [App\Http\Controllers\Api\ProductController::class, 'show']);

// Shipment API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/shipments', [App\Http\Controllers\Api\ShipmentController::class, 'index']);
    Route::post('/shipments', [App\Http\Controllers\Api\ShipmentController::class, 'store']);
    Route::get('/shipments/{id}', [App\Http\Controllers\Api\ShipmentController::class, 'show']);
    Route::patch('/shipments/{id}/status', [App\Http\Controllers\Api\ShipmentController::class, 'updateStatus']);
});
