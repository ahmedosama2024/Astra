<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {
    Route::apiResource('categories', CategoryController::class)->except('store');
    Route::apiResource('categories.products', ProductController::class)->scoped();
    Route::apiResource('prices', PriceController::class);
});