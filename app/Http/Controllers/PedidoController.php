<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with('cliente');

        if ($request->filled('search')) {
            $query->whereHas('cliente', function($q) use ($request) {
                $q->where('nome', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sort = $request->get('sort', 'data_pedido');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $pedidos = $query->paginate(20);
        
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();
        return view('pedidos.create', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id'  => 'required|exists:clientes,id',
            'data_pedido' => 'required|date',
            'status'      => 'required|in:Em Aberto,Pago,Cancelado',
            'total'       => 'nullable|numeric'
        ]);

        Pedido::create($data);

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido criado com sucesso.');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load('cliente');
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::orderBy('nome')->get();
        return view('pedidos.edit', compact('pedido', 'clientes'));
    }

    public function update(Request $request, Pedido $pedido)
    {

        $data = $request->validate([
            'cliente_id'  => 'required|exists:clientes,id',
            'data_pedido' => 'required|date',
            'status'      => 'required|in:Em Aberto,Pago,Cancelado',
            'total'       => 'nullable|numeric'
        ]);

        $pedido->update($data);

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido atualizado com sucesso.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido excluído com sucesso.');
    }
}
