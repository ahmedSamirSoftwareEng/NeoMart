<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\DashboardController;

Route::group(['middleware' => 'auth' , 'prefix' => 'dashboard' ,'as' => 'dashboard.'] , function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('categories', CategoriesController::class)->names('categories');
});
