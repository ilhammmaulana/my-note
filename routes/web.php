<?php

use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\ProfileController;
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
    Route::resource('profile', ProfileController::class)->only('index');
    Route::resource('users', UserController::class);
    Route::resource('admins', AdminController::class)->only('show', 'index', 'store', 'destroy', 'update')->middleware('role:super_admin');
    Route::delete('auth/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::fallback(function () {
    if (!request()->is('public/*')) {
        return redirect('/auth/login');
    }
    abort(404);
});
