<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/clients', function() {
    return view('app.clients');
})->name('clients')->middleware('auth');

Route::get('/products', function() {
    return view('app.products');
})->name('products')->middleware('auth');

Route::get('/orders', function() {
    return view('app.orders');
})->name('orders')->middleware('auth');
