<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\CartController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
// products
Route::get('/products',  [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('products.show');
// cart
Route::resource('cart', CartController::class);

require __DIR__ . '/dashboard.php';
require __DIR__ . '/auth.php';
