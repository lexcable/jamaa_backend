<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\OrderItemController;
use App\Http\Controllers\API\AuthTestController;
use App\Http\Controllers\API\MpesaController;
use App\Http\Controllers\API\SmsController;

    // Public
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::get('/test-token', [AuthTestController::class, 'getToken']);

    Route::prefix('mpesa')->group(function () {
            Route::get('token', [MpesaController::class, 'token']);
            Route::post('register-url', [MpesaController::class, 'registerClientUrl']);
            Route::post('push', [MpesaController::class, 'stkPushRequest']);
            Route::post('push/status', [MpesaController::class, 'checkStkPushStatus']);
            Route::post('push/response', [MpesaController::class, 'stkPushCallback']);
            Route::post('callbacks/stk', [MpesaController::class, 'stkPushCallback'])->name('mpesa.stk.callback');
            Route::post('c2b/confirmation', [MpesaController::class, 'c2bConfirmation'])->name('mpesa.c2b.confirmation');
            Route::post('c2b/validation', [MpesaController::class, 'validation'])->name('mpesa.c2b.validation');
            Route::post('amount/validate', [MpesaController::class, 'amountBeingPaidIsValid']);
        });

    Route::post('africastalking/sms', [SmsController::class, 'send']);


    
// Authenticated
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // --- Categories (any authenticated user can READ) ---
    Route::get('categories',           [CategoryController::class, 'index']);
    Route::get('categories/{category}',[CategoryController::class, 'show']);

    // --- Products (any authenticated user can READ) ---
    //Route::get('products',           [ProductController::class, 'index']);
    //Route::get('products/{id}',      [ProductController::class, 'show']);


        

    
    
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


Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
