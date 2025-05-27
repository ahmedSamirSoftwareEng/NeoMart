<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
// products
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('products.show');


require __DIR__ . '/dashboard.php';
require __DIR__ . '/auth.php';
