<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::prefix('v1')->middleware('jwt.auth')->group(function () {
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/clients', ClientController::class);
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/orders', OrderController::class);


    Route::get('/all-clients', [ClientController::class, 'getClients']);
    Route::get('/all-products', [ProductController::class, 'getProducts']);
    Route::get('/all-orders', [OrderController::class, 'getOrders']);
});


Route::post('/login', [AuthController::class, 'login']);



