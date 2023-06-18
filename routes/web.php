<?php

use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\UserController;
use Illuminate\Support\Facades\Route;



Route::group([
    "prefix" => "auth",
    "guard" => "guest"
], function () {
    Route::get('/login', [AuthController::class, 'viewLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::delete('auth/logout', [AuthController::class, 'logout'])->name('logout');
});
