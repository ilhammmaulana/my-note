<?php

use App\Http\Controllers\WEB\AuthController;
use Illuminate\Support\Facades\Route;



Route::group([
    "prefix" => "auth",
    "guard" => "guest"
], function () {
    Route::get('/login', [AuthController::class, 'viewLogin']);
});
