<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\VerifyAge;
use Illuminate\Support\Facades\Route;

Route::get('/',[ProductController::class,'index'])->name('welcome');

Route::resource('products', ProductController::class)
    ->only(['index', 'show'])
    ->middlewareFor(['show'], VerifyAge::class);

// Age verification route
Route::get('/age-verification', function () {
    return view('age-verification');
})->name('age.verification');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
