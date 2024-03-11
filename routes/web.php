<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\HomeController;

Route::prefix('cliente')->name('clients.')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('index');
    Route::get('/adicionar', [ClientController::class, 'create'])->name('create');
    Route::post('/', [ClientController::class, 'store'])->name('store');
    Route::get('/deletados', [ClientController::class, 'showDeleted'])->name('show_deleted');
    Route::get('/{cliente}', [ClientController::class, 'show'])->name('show');
    Route::get('/{cliente}/editar', [ClientController::class, 'edit'])->name('edit');
    Route::put('/{cliente}', [ClientController::class, 'update'])->name('update');
    Route::delete('/{cliente}', [ClientController::class, 'destroy'])->name('destroy');
    Route::delete('/{cliente}/deletar', [ClientController::class, 'softDeleted'])->name('soft_deleted');
    Route::put('/{cliente}/restaurar', [ClientController::class, 'restore'])->name('restore');
    Route::get('/search/{name}', [ClientController::class, 'searchClients'])->name('search');
});

Route::prefix('produto')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/criar', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/deletados', [ProductController::class, 'showDeleted'])->name('show_deleted');
    Route::get('/{produto}', [ProductController::class, 'show'])->name('show');
    Route::get('/{produto}/editar', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{produto}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{produto}', [ProductController::class, 'destroy'])->name('destroy');
    Route::delete('/{produto}/deletar', [ProductController::class, 'softDeleted'])->name('soft_deleted');
    Route::put('/{produto}/restaurar', [ProductController::class, 'restore'])->name('restore');
    Route::get('/filtro/{categoria}', [ProductController::class, 'filterProducts'])->name('filter');
});

Route::prefix('pedido')->name('purchase_orders.')->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'index'])->name('index');
    Route::get('/adicionar', [PurchaseOrderController::class, 'create'])->name('create');
    Route::post('/', [PurchaseOrderController::class, 'store'])->name('store');
    Route::get('/deletados', [PurchaseOrderController::class, 'showDeleted'])->name('show_deleted');
    Route::get('/{pedido}', [PurchaseOrderController::class, 'show'])->name('show');
    Route::get('/{pedido}/editar', [PurchaseOrderController::class, 'edit'])->name('edit');
    Route::put('/{pedido}', [PurchaseOrderController::class, 'update'])->name('update');
    Route::delete('/{pedido}', [PurchaseOrderController::class, 'destroy'])->name('destroy');
    Route::delete('/{pedido}/deletar', [PurchaseOrderController::class, 'softDeleted'])->name('soft_deleted');
    Route::put('/{pedido}/restaurar', [PurchaseOrderController::class, 'restore'])->name('restore');
});

Route::get('/categoria', [CategorieController::class, 'index'])->name('categories.index');
Route::post('/categoria', [CategorieController::class, 'store'])->name('categories.store');
Route::delete('/categoria/{categoria}', [CategorieController::class, 'destroy'])->name('categories.destroy');

Route::get('/', [HomeController::class, 'index'])->name('home');
