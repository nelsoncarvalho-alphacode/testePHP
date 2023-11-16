<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedidos\pedidos;
use App\Models\Produtos\produtos;

class PedidosController extends Controller
{
    protected $pedidoModel;
    protected $produtoModel;

    public function __construct(
        pedidos $pedidoModel,
        produtos $produtosModel
    ) {
        $this->pedidoModel = $pedidoModel;
        $this->produtoModel = $produtosModel;
    }

    public function listagemPedidos() {
        $pedidos = $this->pedidoModel->all();
        return view("Pedidos.ListagemPedidos", ["pedidos" => $pedidos]);
    }

    public function cadastroPedidos() {
        $produtos = $this->produtoModel->all();
        return view("Pedidos.CadastroPedido", ["produtos" => $produtos]);
    }

}
