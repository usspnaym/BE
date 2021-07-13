<?php

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
Route::post('/auth/register',[\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/auth/login',[\App\Http\Controllers\AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->get('/auth/me',[\App\Http\Controllers\AuthController::class, 'me']);

Route::apiResource('posts', \App\Http\Controllers\PostController::class);
Route::apiResource('categories', \App\Http\Controllers\CategoryController::class, [
    'only' => ['index', 'show', 'store', 'update']
]);
