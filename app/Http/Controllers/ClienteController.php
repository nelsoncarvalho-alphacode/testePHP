<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateClienteRequest;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();
    
        if ($request->filled('search')) {
            $query->where('nome', 'like', '%'.$request->search.'%');
        }
        
        $order = $request->input('order', 'id');
        $direction = $request->input('direction', 'asc');
        $query->orderBy($order, $direction);
        
        $clientes = $query->paginate(20);
        
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(StoreClienteRequest $request)
    {
        $cliente = Cliente::create($request->validated());
        
        return redirect()
            ->route('clientes.show', $cliente->id)
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        $pedidos = $cliente->pedidos()->orderBy('data_pedido', 'asc')->get();
        return view('clientes.show', compact('cliente', 'pedidos'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|size:11|unique:clientes,cpf,' . $cliente->id . ',id',
            'email' => 'required|email|max:100|unique:clientes,email,' . $cliente->id . ',id',
        ]);

        $cliente->update($data);

        return redirect()
            ->route('clientes.show', $cliente->id)
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        if ($cliente->pedidos()->exists()) {
            return redirect()
                ->route('clientes.index')
                ->with('error', 'Não é possível excluir cliente com pedidos associados!');
        }
        
        $cliente->delete();
        
        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}