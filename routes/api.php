<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Cart\CartController;
use App\Http\Controllers\API\Category\CategoryController;
use App\Http\Controllers\API\Dish\DishController;
use App\Http\Controllers\Api\Favorite\FavoriteController;
use App\Http\Controllers\API\Notification\NotificationController;
use App\Http\Controllers\API\Order\OrderController;
use App\Http\Controllers\API\Payment\PaymentController;
use App\Http\Controllers\API\User\UserController;

// Public Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']); // camelCase
Route::post('resend-otp', [AuthController::class, 'resendOtp']);
Route::post('login', [AuthController::class, 'login']);

Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetOtp']);
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('dishes',[DishController::class,'index']);
Route::get('dishes/top-rated', [DishController::class, 'topRated']);

// Protected Routes (Sanctum)
Route::middleware('auth:sanctum')->group(function() {

    Route::post('categories', [CategoryController::class, 'store']);
    Route::post('categories/{category}', [CategoryController::class, 'update']); // تعديل مع form-data
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    Route::post('dishes', [DishController::class, 'store']);
    Route::patch('dishes/{dish}', [DishController::class, 'update']);
    Route::delete('dishes/{dish}', [DishController::class, 'destroy']);
     Route::get('favorites', [FavoriteController::class, 'index']); // GET all
    Route::post('favorites', [FavoriteController::class, 'store']); // add
    Route::delete('favorites/{dish}', [FavoriteController::class, 'destroy']);
     Route::get('cart', [CartController::class, 'index']);
    Route::post('cart', [CartController::class, 'store']);
    Route::patch('cart/{cartItem}', [CartController::class, 'update']);
    Route::delete('cart/{cartItem}', [CartController::class, 'destroy']);
    Route::delete('cart', [CartController::class, 'clear']); // مسح كل العناصر
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('my-orders', [OrderController::class,'myOrders']);
    Route::post('payment/pay', [PaymentController::class, 'pay']);
    Route::post('payment/confirm', [PaymentController::class, 'confirmPayment']);
    Route::get('profile', [UserController::class, 'profile']);
    Route::post('profile', [UserController::class, 'update']);
    Route::get('notifications', [NotificationController::class,'index']);
    Route::post('notifications/{id}/read', [NotificationController::class,'markAsRead']);

    // Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);

});
