<?php

use App\Http\Controllers\Website\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::delete('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('signup', [AuthController::class,'signup'])->name('signup');
Route::post('login', [AuthController::class, 'login'])->name('login');
