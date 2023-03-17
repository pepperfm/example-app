<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EntityController;

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
        Route::get('/', [EntityController::class, 'index']);

        Route::get('store', [EntityController::class, 'store']);
        Route::post('store', [EntityController::class, 'store']);

        Route::get('options', [EntityController::class, 'getOptions']);
        Route::get('{entity}', [EntityController::class, 'show']);
        Route::get('update/{entity}', [EntityController::class, 'update']);
        Route::post('update/{entity}', [EntityController::class, 'update']);

        Route::get('{entity}/tree', [EntityController::class, 'showTree']);
    });
});
