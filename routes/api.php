<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(["prefix" => "auth"], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth.refresh');
    Route::post('/register', [AuthController::class, 'register']);
    Route::group([
        'middleware' => 'auth.api',
    ], function () {
        Route::delete('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::get('register', [AuthController::class, 'register']);
        Route::post('change-password', [AuthController::class, 'updatePassword']);
    });
});


Route::middleware(['auth.api'])->group(function () {
    Route::resource('notes', NoteController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::group([
        'prefix' => 'user'
    ], function () {
        Route::post('profile', [AuthController::class, 'update']);
    });
});
