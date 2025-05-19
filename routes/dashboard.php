<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\DashboardController;

Route::group(['middleware' => 'auth' , 'prefix' => 'dashboard' ,'as' => 'dashboard.'] , function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    // trash
    Route::get('/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');
    // Categories
    Route::resource('categories', CategoriesController::class)->names('categories');
});
