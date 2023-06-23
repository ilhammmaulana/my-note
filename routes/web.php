<?php

use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\UserController;
use Illuminate\Support\Facades\Route;



Route::group([
    "prefix" => "auth",
    "middleware" => 'guest'
], function () {
    Route::get('/login', [AuthController::class, 'viewLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('admins', AdminController::class);
    Route::delete('auth/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::fallback(function () {
    if (!request()->is('public/*')) {
        return redirect('/auth/login');
    }
    abort(404);
});
