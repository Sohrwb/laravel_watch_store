<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemController;

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/about', [ProductController::class, 'about'])->name('about');
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/products', [ProductController::class, 'filterProduct'])->name('products.index');
Route::get('products/show/{product}', [ProductController::class, 'show'])->name('product.show');

//-----------------------------------------[ auth  ]-----------------------------------------------

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//-----------------------------------------[ forget password  ]-----------------------------------------------

Route::get('/forget', [AuthController::class, 'forget'])->name('forget');
Route::post('/forget', [AuthController::class, 'forgetpost'])->name('forgetpost');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::post('/reset-password', [AuthController::class, 'resetPasswordPost'])->name('resetPassword.post');

//-----------------------------------------[ profile ]-----------------------------------------------

Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/user/invoices', [InvoiceController::class, 'index'])->name('user.invoices')->middleware('auth');

//-----------------------------------------[ admin ]-----------------------------------------------

Route::group([
    'prefix' => '/admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'is_admin']
], function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/colors', [ColorController::class, 'store'])->name('colors.store');
});

//-----------------------------------------[ category ]-----------------------------------------------

Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

//-----------------------------------------[ cart ]-----------------------------------------------

Route::group([
    'prefix' => '/cart',
    'as' => 'cart.',
    'middleware' => ['auth']
], function () {
    Route::post('/add', [CartController::class, 'addToCart'])->name('add');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

//-----------------------------------------[ cart-item ]-----------------------------------------------

Route::group([
    'prefix' => '/cart-item',
    'as' => 'cart-item.',
    'middleware' => ['auth']
], function () {
    Route::delete('/{id}', [CartItemController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/edit', [CartItemController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CartItemController::class, 'update'])->name('update');
});

//-----------------------------------------[ payment ]-----------------------------------------------

Route::group([
    'prefix' => '/payment',
    'as' => 'payment.',
    'middleware' => ['auth']
], function () {
    Route::get('/{id}', [CartController::class, 'showGateway'])->name('gateway');
    Route::post('/confirm/{id}', [CartController::class, 'confirmPayment'])->name('confirm');
    Route::post('/cancel/{id}', [CartController::class, 'cancelPayment'])->name('cancel');
});

//-----------------------------------------[ invoice ]-----------------------------------------------

Route::post('invoice/{invoice}/pay', [InvoiceController::class, 'pay'])->middleware('auth')->name('invoice.pay');
Route::delete('invoice/{invoice}', [InvoiceController::class, 'destroy'])->middleware('auth')->name('invoice.destroy');
