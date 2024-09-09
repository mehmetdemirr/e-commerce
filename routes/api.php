<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Api\PaymentStatusController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;


Route::middleware(["log"])->group(function () {
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(35)->by(optional($request->user())->id ?: $request->ip());
    });
    
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('user', [UserController::class, 'user']);
        Route::put('user/update', [UserController::class, 'update']);

        Route::prefix('products')->group(function () {  //ürünler
            Route::get('/', [ProductController::class, 'index']);
            Route::get('/company', [ProductController::class, 'getProductsByBusiness']);
            Route::get('/{id}', [ProductController::class, 'show']);
            Route::post('/', [ProductController::class, 'store']);
            Route::put('/{id}', [ProductController::class, 'update']);
            Route::delete('/{id}', [ProductController::class, 'destroy']);
        });

        Route::prefix('brands')->group(function () { //markalar
            Route::get('/', [BrandController::class, 'index']);
            Route::get('/{id}', [BrandController::class, 'show']);
            Route::post('/', [BrandController::class, 'store']);
            Route::put('/{id}', [BrandController::class, 'update']);
            Route::delete('/{id}', [BrandController::class, 'destroy']);
        });

        Route::prefix('categories')->group(function () { //kategoriler
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('/{id}', [CategoryController::class, 'show']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::put('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
        });

        Route::prefix('product-images')->group(function () { //ürün fotoğrafları
            Route::get('/', [ProductImageController::class, 'index']);
            Route::get('/{id}', [ProductImageController::class, 'show']);
            Route::post('/', [ProductImageController::class, 'store']);
            Route::put('/{id}', [ProductImageController::class, 'update']);
            Route::delete('/{id}', [ProductImageController::class, 'destroy']);
        });

        Route::prefix('/carts')->group(function () {  //sepet işlemleri
            Route::get('/', [CartController::class, 'index']);
            Route::post('/', [CartController::class, 'store']); 
            Route::delete('/{itemId}', [CartController::class, 'destroy']); 
            Route::put('/{itemId}', [CartController::class, 'update']); 
        });

        Route::prefix('/orders')->group(function () { //sipariş işlemleri
            Route::post('/', [OrderController::class, 'create']);
            Route::put('/{orderId}', [OrderController::class, 'update']);
            Route::get('/', [OrderController::class, 'getOrdersByAuthenticatedUser']);
            Route::get('/user/{userId}', [OrderController::class, 'getOrdersByUserId']);
            Route::get('/company', [OrderController::class, 'getOrdersByBusinessId']);
        });

        Route::prefix('/order-statuses')->group(function () {
            Route::get('/', [OrderStatusController::class, 'index']);
            Route::get('/{id}', [OrderStatusController::class, 'show']);
            Route::post('/', [OrderStatusController::class, 'store']);
            Route::put('/{id}', [OrderStatusController::class, 'update']);
            Route::delete('/{id}', [OrderStatusController::class, 'destroy']);
        });
        
        Route::prefix('/payment-statuses')->group(function () {
            Route::get('/', [PaymentStatusController::class, 'index']);
            Route::get('/{id}', [PaymentStatusController::class, 'show']);
            Route::post('/', [PaymentStatusController::class, 'store']);
            Route::put('/{id}', [PaymentStatusController::class, 'update']);
            Route::delete('/{id}', [PaymentStatusController::class, 'destroy']);
        });
        
        
        //admin route
        Route::middleware(["role:admin"])->group(function () {
            
        });
    
        //company route
        Route::middleware(["role:company"])->group(function () {
            
        });
    
        //user route
        Route::middleware(["role:user"])->group(function () {
           
        });
    
    
    });
    
    Route::middleware(["throttle:30,1"])->group(function () {
        Route::post('auth/login', [AuthController::class, 'login']);
        Route::post('auth/register', [AuthController::class, 'register']);
    
        Route::post('auth/password-forgot',[ForgotPasswordController::class,'forgotPassword']);
        Route::post('auth/password-reset',[ResetPasswordController::class,'resetPassword']);
    });
});