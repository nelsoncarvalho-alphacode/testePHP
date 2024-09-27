<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'home']);
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('clients', ClientController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
});
