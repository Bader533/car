<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\OwnerController;
use App\Http\Controllers\Api\FilterController;
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


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'loginPersonal']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

Route::get('city', [CityController::class, 'index']);
Route::get('show/owner/{id}', [OwnerController::class, 'show']);
Route::post('/filtering', [FilterController::class, 'filterCars']);
Route::get('/phone/{id}', [FilterController::class, 'callCount']);
Route::post('/same-car', [FilterController::class, 'sameCar']);
Route::get('car', [CarController::class, 'index']);
Route::get('car/{id}', [CarController::class, 'show']);
Route::get('carName', [CarController::class, 'carName']);
Route::get('cityName', [CarController::class, 'cityName']);

Route::middleware('auth:owner-api')->group(function () {
    Route::put('/owner/update', [OwnerController::class, 'update']);
    Route::get('show/owner-deatails', [OwnerController::class, 'ownerProfile']);
    Route::post('car', [CarController::class, 'store']);
    Route::put('car/{id}', [CarController::class, 'update']);
    Route::delete('car/{id}', [CarController::class, 'destroy']);
    Route::apiResource('favorite', FavoriteController::class);
});

Route::prefix('auth')->middleware('auth:owner-api')->group(function () {
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::get('logout', [AuthController::class, 'logout']);
});
