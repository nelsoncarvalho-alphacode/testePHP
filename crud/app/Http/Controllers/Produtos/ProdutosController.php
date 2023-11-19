<?php

namespace App\Http\Controllers\Produtos;

use App\Http\Controllers\Controller;
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

    public function listagemProdutos()
    {
        try {
            $produtos = $this->produtoModel->paginate(9);
            return view('Produtos.ListagemProdutos', ["produtos" => $produtos]);
        } catch (\Exception $e) {
            return view('error')->with('error', $e->getMessage());
        }
    }

    public function cadastrarProdutos() {
        return view('Produtos.CadastroProdutos');
    }

    public function salvarProdutos(Request $request) {
        $dados = $request->all();
        try {
            if ($request->isMethod('post')) {
                $this->produtosService->salvarProduto($dados);
                return redirect()->route('produtos')->with('success', 'Produto cadastrado com sucesso.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar o produto: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $produto = produtos::findOrFail($id);
            $produto->delete();

            return redirect()->route('produtos')->with('success', 'Produto excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('produtos')->with('error', 'Erro ao excluir o produto: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        try {
            $produto = produtos::findOrFail($id);
            return view('Produtos.editProdutos', ['produto' => $produto]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('produtos')->with('error', 'Produto não encontrado.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $produto = produtos::findOrFail($id);
            $produto->update($request->all());

            return redirect()->route('produtos')->with('success', 'Produto editado com sucesso.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('produtos')->with('error', 'Produto não encontrado.');
        }
    }


}
