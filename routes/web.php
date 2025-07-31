<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'home'])->name('home');


Route::get('products/show/{product}', [ProductController::class, 'show'])->name('product.show');


Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');

//auth
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//forget password
Route::get('/forget', [AuthController::class, 'forget'])->name('forget');
Route::post('/forget', [AuthController::class, 'forgetpost'])->name('forgetpost');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::post('/reset-password', [AuthController::class, 'resetPasswordPost'])->name('resetPassword.post');



//admin
Route::middleware(['auth', 'is_admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
});


//invoice and cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->middleware('auth')->name('cart.edit');
Route::post('/cart/add', [CartController::class, 'addToCart'])->middleware('auth')->name('cart.delete');
Route::post('/cart/add', [CartController::class, 'addToCart'])->middleware('auth')->name('cart.add');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->middleware('auth')->name('cart.checkout');

Route::get('/payment/{id}', [CartController::class, 'showGateway'])->middleware('auth')->name('payment.gateway');
Route::post('/payment/confirm/{id}', [CartController::class, 'confirmPayment'])->middleware('auth')->name('payment.confirm');
Route::post('/payment/cancel/{id}', [CartController::class, 'cancelPayment'])->middleware('auth')->name('payment.cancel');
