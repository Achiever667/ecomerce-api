<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// User dashboard, profile, orders, and cart routes protected by auth middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/user/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    Route::get('/user/orders', function () {
        return view('user.orders');
    })->name('user.orders');

    Route::get('/user/cart', function () {
        return view('user.cart');
    })->name('user.cart');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'loginWeb']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

// Admin login routes
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', [\App\Http\Controllers\AuthController::class, 'adminLoginWeb']);

// Admin dashboard route protected by role middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
