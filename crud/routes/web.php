<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Produtos\ProdutosController;
use App\Http\Controllers\Pedidos\PedidosController;

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
    return view('home');
})->name('home');

Route::get('/pedidos', [PedidosController::class, 'listagemPedidos'])->name('pedidos');
Route::post('/pedidosCadastro', [PedidosController::class, 'cadastroPedidos'])->name('cadastroPedidos');
Route::get('/comprar/{id}', [PedidosController::class, 'show'])->name('comprar.show');
Route::post('/comprar/confirmar/{id}', [PedidosController::class, 'confirmar'])->name('comprar.confirm');
Route::delete('/pedidos/{id}', [PedidosController::class, 'destroy'])->name('pedidos.destroy');
Route::get('/pedidos/editar/{id}', [PedidosController::class, 'edit'])->name('pedidos.edit');
Route::put('pedidos/update/{id}', [PedidosController::class, 'update'])->name('pedidos.update');
Route::get('/pedidos/pagar/{id}', [PedidosController::class, 'pagar'])->name('pedidos.pagar');
Route::get('/pedidos/cancelar/{id}', [PedidosController::class, 'cancelar'])->name('pedidos.cancelar');


Route::get('/produtos', [ProdutosController::class, 'listagemProdutos'])->name('produtos');
Route::get('/produtosCadastro', [ProdutosController::class, 'cadastrarProdutos'])->name('produtosCadastro');
Route::post('/produtosSalvo', [ProdutosController::class, 'salvarProdutos'])->name('produtosSalvo');
Route::delete('/produtos/{id}', [ProdutosController::class, 'destroy'])->name('produtos.destroy');
Route::get('produtos/editar/{id}', [ProdutosController::class, 'edit'])->name('produtos.edit');
Route::put('produtos/update/{id}', [ProdutosController::class, 'update'])->name('produtos.update');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
