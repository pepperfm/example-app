<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{AuthController, ProductController};

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

/**
 * @see https://api.postman.com/collections/7158931-01c5d9b8-e030-42ec-9490-9c40b38db861?access_key=PMAT-01GWZ7NSTPRF2FMSZAS2ZA9HXK
 */

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'auth:sanctum',
], static function (): void {
    Route::get('/user', static fn(Request $request) => response()->json(['user' => $request->user()]));

    Route::get('products', [ProductController::class, 'index']);
});
