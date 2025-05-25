<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CMSController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Product management routes (admin only)
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Cart routes
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'add']);
    Route::delete('/cart/{id}', [CartController::class, 'remove']);

    // Order routes
    Route::get('/orders', [OrderController::class, 'index']); // user order history
    Route::post('/checkout', [OrderController::class, 'checkout']); // place order

    // Admin order management
    Route::get('/admin/orders', [OrderController::class, 'allOrders']);
    Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus']);

    // CMS routes (admin only)
    Route::get('/cms-pages', [CMSController::class, 'index']);
    Route::post('/cms-pages', [CMSController::class, 'store']);
    Route::get('/cms-pages/{id}', [CMSController::class, 'show']);
    Route::put('/cms-pages/{id}', [CMSController::class, 'update']);
    Route::post('/cms-pages/{id}/archive', [CMSController::class, 'archive']);
});
