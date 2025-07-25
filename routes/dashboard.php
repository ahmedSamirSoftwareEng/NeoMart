<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ImportProductsController;

Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin/dashboard', 'as' => 'dashboard.'], function () {
    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    // trash
    Route::get('/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');
    // products import
    Route::get('/products/import', [ImportProductsController::class, 'create'])->name('products.import');
    Route::post('/products/import', [ImportProductsController::class, 'store'])->name('products.import');
    // Categories
    Route::resource('categories', CategoriesController::class)->names('categories');
    //products
    Route::resource('products', ProductsController::class)->names('products');
    // roles
    Route::resource('roles', \App\Http\Controllers\Dashboard\RolesController::class)->names('roles');
    // admins
    Route::resource('admins', \App\Http\Controllers\Dashboard\AdminsController::class)->names('admins');
    //users
    Route::resource('users', \App\Http\Controllers\Dashboard\UsersController::class)->names('users');
});
