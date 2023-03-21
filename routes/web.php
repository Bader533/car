<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarNameController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest:admin')->group(function () {
    Route::get('{guard}/login', [AuthController::class, 'showLogin'])->name('dashboard.login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});


Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [Controller::class, 'totalCount'])->name('homepage');
        Route::resource('owner', OwnerController::class);
        Route::resource('city', CityController::class);
        Route::resource('carName', CarNameController::class);
        Route::resource('car', CarsController::class);
        Route::resource('admin', AdminController::class);
        Route::delete('image/delete/{id}', [Controller::class, 'deleteImage'])->name('delete.image');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
