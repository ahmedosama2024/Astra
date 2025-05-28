<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'auth:api'
], function () {
    Route::delete('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
