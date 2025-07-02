<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\OrderItemController;
use App\Http\Controllers\API\AuthTestController;
use App\Http\Controllers\API\MpesaController;

    // Public
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::get('/test-token', [AuthTestController::class, 'getToken']);

    
// Authenticated
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // --- Categories (any authenticated user can READ) ---
    Route::get('categories',           [CategoryController::class, 'index']);
    Route::get('categories/{category}',[CategoryController::class, 'show']);

    // --- Products (any authenticated user can READ) ---
    Route::get('products',           [ProductController::class, 'index']);
    Route::get('products/{id}',      [ProductController::class, 'show']);

    // --- M-PESA Integration ---
    Route::post('/mpesa/stkpush', [MpesaController::class, 'stkPush']);
    Route::post('/mpesa/callback', [MpesaController::class, 'stkCallback']);
    Route::post('/stk/push/{id}', [MpesaController::class, 'payOrder']);

    // M-PESA C2B (Customer to Business) routes
    Route::post('/c2b/confirmation', [MpesaController::class, 'confirm']);
    Route::post('/c2b/validation', [MpesaController::class, 'validateTransaction']);
    Route::get('/c2b/register', [MpesaController::class, 'registerUrls']);
    
    
    // Client‑only actions
    Route::middleware(CheckRole::class . ':client')->group(function () {
        Route::post('orders',          [OrderController::class, 'store']);
        Route::get('orders',           [OrderController::class, 'index']);
        Route::get('orders/{id}',      [OrderController::class, 'show']);
    });
    

    // Order items
    Route::resource('order-items', OrderItemController::class)
             ->except(['create','edit']);

    // Admin‑only actions
    Route::middleware(CheckRole::class . ':admin')->group(function () {
        // Category management
        Route::post('categories',           [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}',[CategoryController::class,'destroy']);

        // Product management
        Route::post('products',       [ProductController::class, 'store']);
        Route::put('products/{id}',   [ProductController::class, 'update']);
        Route::delete('products/{id}',[ProductController::class, 'destroy']);

        // Order management
        Route::get('all-orders',      [OrderController::class, 'allOrders']);
        Route::put('orders/{id}',     [OrderController::class, 'update']);
        Route::delete('orders/{id}',  [OrderController::class, 'destroy']);
        Route::patch('orders/{id}/shipping', [OrderController::class, 'updateShipping'])
                ->middleware(CheckRole::class . ':admin');


        // Order items
        Route::resource('order-items', OrderItemController::class)
             ->except(['create','edit']);
    });
});
