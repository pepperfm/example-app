<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'auth:sanctum'
], static function () {
    Route::get('/user', fn(Request $request) => response()->json(['user' => $request->user()]));

    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

    Route::group([
        'prefix' => 'entities',
        'as' => 'entities.'
    ], static function () {
        Route::get('store', [\App\Http\Controllers\EntityController::class, 'store']);
        Route::post('store', [\App\Http\Controllers\EntityController::class, 'store']);

        Route::get('options', [\App\Http\Controllers\EntityController::class, 'getOptions']);
        Route::get('{entity}', [\App\Http\Controllers\EntityController::class, 'show']);
        Route::get('update/{entity}', [\App\Http\Controllers\EntityController::class, 'update']);
        Route::post('update/{entity}', [\App\Http\Controllers\EntityController::class, 'update']);
    });
});
