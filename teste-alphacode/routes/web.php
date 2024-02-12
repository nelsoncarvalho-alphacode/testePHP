<?php

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

use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);

Route::get('/clientes', function () {
    return view('clientes');
});

Route::get('/produtos', [ProductController::class, 'index'])->name('produtos.list');

Route::get('/produtos/{id}/edit', [ProductController::class, 'edit'])->name('produtos.edit');

Route::get('/novo-produto', [ProductController::class, 'create'])->name('produtos.create');

Route::post('/store-produto', [ProductController::class, 'store'])->name('produto.store');

Route::put('/produtos/{id}', [ProductController::class, 'update'])->name('produto.update');

Route::delete('/produtos/{id}', [ProductController::class, 'destroy'])->name('produto.destroy');

Route::get('/pedidos', function () {
    return view('pedidos');
});
