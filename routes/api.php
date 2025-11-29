<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Category\CategoryController;

// Public Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']); // camelCase
Route::post('resend-otp', [AuthController::class, 'resendOtp']);
Route::post('login', [AuthController::class, 'login']);

Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetOtp']);
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);
Route::get('categories', [CategoryController::class, 'index']);

// Protected Routes (Sanctum)
Route::middleware('auth:sanctum')->group(function() {

    Route::post('categories', [CategoryController::class, 'store']);
    Route::patch('categories/{category}', [CategoryController::class, 'update']); // تعديل مع form-data
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);

});
