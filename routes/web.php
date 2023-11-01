<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetailsPurchaseController;
use App\Http\Controllers\ClientController;
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

//
//Route::prefix('detailsPurchase')->group(function () {
    Route::get('/', [ClientController::class,'index']);
//});

Route::prefix('client')->group(function () {
    Route::get('create', [ClientController::class,'create'])->name('create_client');
    Route::get('index', [ClientController::class,'index'])->name('list_client');
    Route::get('show', [ClientController::class,'show'])->name('show_client');
    Route::post('store', [ClientController::class,'store'])->name('store_client');
    Route::put('update', [ClientController::class,'update'])->name('update_client');
    Route::delete('destroy/{client}', [ClientController::class,'destroy'])->name('destroy_client');
});

Route::prefix('product')->group(function () {
    Route::get('create', [ProductController::class,'create'])->name('create_product');
    Route::get('index', [ProductController::class,'index'])->name('list_product');
    Route::get('show', [ProductController::class,'show'])->name('show_product');
    Route::post('store', [ProductController::class,'store'])->name('store_product');
    Route::put('update', [ProductController::class,'update'])->name('update_product');
    Route::delete('destroy/{product}', [ProductController::class,'destroy'])->name('destroy_product');
    Route::get('amount/{id}', [\App\Models\Product::class,'getAmountByProduct'])->name('amountByProduct');
});

Route::prefix('purchase')->group(function () {
    Route::get('create', [PurchaseRequestController::class,'create'])->name('create_purchase');
    Route::get('index', [PurchaseRequestController::class,'index'])->name('list_purchase');
    Route::get('show', [PurchaseRequestController::class,'show'])->name('show_purchase');
    Route::post('store', [PurchaseRequestController::class,'store'])->name('store_purchase');
    Route::put('updateStatus/{id}/{status}', [PurchaseRequestController::class,'updateStatus'])->name('update_status_order');
    Route::put('update', [PurchaseRequestController::class,'update'])->name('update_purchase');
    Route::get('show', [PurchaseRequestController::class,'show'])->name('show_purchase');
    //    Route::delete('destroy/{product}', [ProductController::class,'destroy'])->name('destroy_product');
});
Route::fallback(function () {
    return view('partials.notfound');
});
