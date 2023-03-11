<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Order\GetOrderController;
use App\Http\Controllers\Api\Order\ShowOrderController;
use App\Http\Controllers\Api\Order\StoreOrderController;
use App\Http\Controllers\Api\Order\UserOrderController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/auth'], function () {
    Route::post('/register',                    RegisterController::class);
    Route::post('/login',                       LoginController::class);
});

// Route::get('/orders/index',                 GetOrderController::class);
Route::get('/orders/{order_id}',            ShowOrderController::class);
Route::get('/orders',                       UserOrderController::class);
Route::post('/orders',                      StoreOrderController::class);
