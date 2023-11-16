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

Route::get('/cadastro', [CadastroController::class, 'cadastro'])->name("cadastro");
Route::post('/clienteSalvo', [CadastroController::class, 'salvarCliente'])->name('salvarCliente');

Route::get('/produtos', [ProdutosController::class, 'listagemProdutos'])->name('produtos');
Route::get('/produtosCadastro', [ProdutosController::class, 'cadastrarProdutos'])->name('produtosCadastro');
Route::post('produtosSalvo', [ProdutosController::class, 'salvarProdutos'])->name('produtosSalvo');

Route::get('/pedidos', [PedidosController::class, 'listagemPedidos'])->name('pedidos');
Route::post('/pedidosCadastro', [PedidosController::class, 'cadastroPedidos'])->name('cadastroPedidos');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
