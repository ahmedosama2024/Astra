<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'auth:api'
], function () {
    Route::apiResource('categories', CategoryController::class)->except('store');
    Route::apiResource('categories.products', ProductController::class)->scoped();
    Route::apiResource('prices', PriceController::class);
    Route::apiResource('roles', RoleController::class)->except('store', 'update');
    Route::apiResource('users', UserRoleController::class)->only('update');
});