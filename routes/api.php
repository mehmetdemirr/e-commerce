<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum',"role:user"])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('user', [UserController::class, 'user']);
});

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::post('auth/password-forgot',[ForgotPasswordController::class,'forgotPassword']);
Route::post('auth/password-reset',[ResetPasswordController::class,'resetPassword']);