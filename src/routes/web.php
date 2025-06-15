<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

Route::name('view.')->middleware('auth')->group(function(){
    Route::get('/clientes', function () {
        return view('pages/clients');
    })->name('clients');
    Route::get('/clientes/{id}', function () {
        return view('pages/clients');
    })->name('clients.id');

    Route::get('/produtos', function () {
        return view('pages/products');
    })->name('products');
    Route::get('/produtos/{id}', function () {
        return view('pages/products');
    })->name('products.id');

    Route::get('/pedidos', function () {
        return view('pages/orders');
    })->name('orders');
});

Route::get('/', function () {
    return redirect('clientes');
});

Route::get('/login', function() {
    if(Auth::check())
        return redirect('clientes');
    else
        return view('auth/login');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');
