<?php

namespace App\Http\Controllers\Produtos;

use App\Http\Controllers\Controller;
use App\Http\Requests\salvarProdutos;
use App\Models\Produtos\produtos;
use App\Services\Produtos\ProdutosServices;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    protected $produtoModel;
    private $produtosService;

    public function __construct(
        produtos $produtoModel,
        ProdutosServices     $produtosService
    ) {
        $this->produtoModel = $produtoModel;
        $this->produtosService = $produtosService;
    }

    public function listagemProdutos() {
        $produtos = $this->produtoModel->all();
        return view('Produtos.ListagemProdutos', ["produtos" => $produtos]);
    }

    public function cadastrarProdutos() {
        return view('Produtos.CadastroProdutos');
    }

    public function salvarProdutos(Request $request) {
        $dados = $request->all();
        if ($request->isMethod('post')) {
            $this->produtosService->salvarProduto($dados);
            return redirect()->route('home');
        } else {
            echo 'tchau';
        }
    }
}
