<?php

use App\Http\Controllers\Front\Auth\TwoFactorAuthentication;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
// products
Route::get('/products',  [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('products.show');
// cart
Route::resource('cart', CartController::class);
// checkout
Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store']);


// 2FA
Route::get('/auth/user/2fa', [TwoFactorAuthentication::class, 'index'])->name('front.2fa');

// 
Route::post('currency', [CurrencyConverterController::class, 'store'])->name('currency.store');
require __DIR__ . '/dashboard.php';
// require __DIR__ . '/auth.php';
