<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedidos\pedidos;
use App\Models\Produtos\produtos;
use Illuminate\Support\Facades\Auth;
use App\Services\Pedidos\PedidosService;

class PedidosController extends Controller
{
    protected $pedidoModel;
    protected $produtoModel;
    private $pedidosService;

    public function __construct(
        pedidos $pedidoModel,
        produtos $produtosModel,
        PedidosService $pedidosService
    ) {
        $this->pedidoModel = $pedidoModel;
        $this->produtoModel = $produtosModel;
        $this->pedidosService = $pedidosService;
    }

    public function listagemPedidos(Request $request)
    {
        $idClienteLogado = Auth::id();
        $order = $request->input('order', 'asc');

        $pedidos = pedidos::where('cliente_id', $idClienteLogado)
            ->orderBy('data_do_pedido', $order)
            ->paginate(10);

        return view("Pedidos.ListagemPedidos", ["pedidos" => $pedidos]);
    }



    public function cadastroPedidos() {
        $produtos = $this->produtoModel->all();
        return view("Pedidos.CadastroPedido", ["produtos" => $produtos[0]->nome]);
    }

    public function edit($id)
    {
        try {
            $pedido = pedidos::findOrFail($id);
            return view('Pedidos.editPedidos', ['pedido' => $pedido]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return redirect()->route('pedidos')->with('error', 'Pedido não encontrado.');
        }
    }


    public function update(Request $request)
    {
        try {
            $pedido = pedidos::findOrFail($request->id);
            $quantidadeAnterior = $pedido->quantidade;
            $pedido->update($request->all());
            $diferencaQuantidade = $pedido->quantidade - $quantidadeAnterior;

            if ($diferencaQuantidade != 0) {
                $produto = produtos::findOrFail($pedido->produto_id);
                $produto->quantidade += $diferencaQuantidade;
                $produto->save();
            }

            return redirect()->route('pedidos')->with('success', 'Pedido editado com sucesso.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return redirect()->route('pedidos')->with('error', 'Pedido não encontrado.');
        }
    }



    public function destroy($id)
    {
        try {
            $pedido = pedidos::findOrFail($id);
            $pedido->delete();

            return redirect()->route('pedidos')->with('success', 'Pedido excluído com sucesso.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return redirect()->route('pedidos')->with('error', 'Pedido não encontrado.');
        }
    }

    public function show(Request $request, $id_produto) {
        $dados = $request->all();
        $produto = produtos::findOrFail($id_produto);
        return view('Pedidos.CompraProdutos', [
            'produto' => $produto,
            'dados' => $dados,
        ]);
    }

    public function confirmar(Request $request, $idProduto)
    {
        try {
            $produto = produtos::findOrFail($idProduto);
            $quantidade = $request->input('quantidade');
            $idCliente = Auth::id();

            if ($quantidade > $produto->quantidade) {
                throw new \Exception('Limite de unidades em estoque atingido.');
            }

            $produto->quantidade -= $quantidade;
            $produto->save();

            $detalhesPedido = [
                'cliente_id' => $idCliente,
                'produto_id' => (int)$idProduto,
                'quantidade' => (int)$quantidade,
            ];

            $this->pedidosService->salvarPedidos($detalhesPedido);
            return redirect()->route('pedidos')->with('success', 'Pedido realizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function pagar($id)
    {
        $pedido = pedidos::findOrFail($id);
        $pedido->status = 'Pago';
        $pedido->save();

        return redirect()->route('pedidos')->with('success', 'Pedido marcado como pago.');
    }

    public function cancelar($id) {
        $pedido = pedidos::findOrFail($id);
        $pedido->status = 'Cancelado';
        $pedido->save();

        return redirect()->route('pedidos')->with('success', 'Pedido cancelado com sucesso.');
    }



}
