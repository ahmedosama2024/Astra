<?php

use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\Website\ProductController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::apiResource('categories', CategoryController::class)->only('index', 'show');
    Route::apiResource('categories.products', ProductController::class)->only('index', 'show')->scoped();
});