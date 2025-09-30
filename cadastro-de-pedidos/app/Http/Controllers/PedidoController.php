<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with('cliente')
            ->withCount('itens');

        // Filtros
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('data_pedido')) {
            $query->whereDate('data_pedido', $request->data_pedido);
        }

        // Ordenação dinâmica
        if ($request->filled('sort') && in_array($request->sort, ['id', 'data_pedido', 'status'])) {
            $query->orderBy($request->sort, $request->get('direction', 'asc'));
        } else {
            $query->orderBy('data_pedido', 'desc');
        }

        $pedidos = $query->paginate(20)->withQueryString();

        $clientes = Cliente::orderBy('nome')->get();

        return view('pedidos.index', compact('pedidos', 'clientes'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();

        return view('pedidos.create', compact('clientes', 'produtos'));
    }

    public function show(Pedido $pedido)
    {
        $pedido->load('itens.produto', 'cliente');
        return view('pedidos.show', compact('pedido'));
    }

    public function store(PedidoRequest $request)
    {
        DB::transaction(function () use ($request) {
            $pedido = Pedido::create($request->only(['cliente_id', 'data_pedido', 'status']));

            foreach ($request->itens as $item) {
                $pedido->itens()->create($item);
            }
        });

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido criado com sucesso!');
    }

    public function edit(Pedido $pedido)
    {
        $pedido->load('itens');
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();

        return view('pedidos.edit', compact('pedido', 'clientes', 'produtos'));
    }

    public function update(PedidoRequest $request, Pedido $pedido)
    {
        DB::transaction(function () use ($pedido, $request) {
            $pedido->update($request->only(['cliente_id', 'data_pedido', 'status']));
            $pedido->itens()->delete();

            foreach ($request->itens as $item) {
                $pedido->itens()->create($item);
            }
        });

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido excluído com sucesso!');
    }
}
