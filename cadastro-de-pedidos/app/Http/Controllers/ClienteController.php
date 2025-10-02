<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $allowed = ['id', 'nome', 'cpf', 'email', 'created_at', 'updated_at'];

        $query = Cliente::query();

        foreach ($allowed as $field) {
            $value = $request->get($field);
            if ($value !== null && $value !== '') {
                if ($field === 'id') {
                    $query->where($field, $value);
                } else {
                    $query->where($field, 'like', "%{$value}%");
                }
            }
        }

        $sort = $request->get('sort');
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        if (in_array($sort, $allowed)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('id', 'desc');
        }

        $clientes = $query->paginate(20)->withQueryString();

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(ClienteRequest $request)
    {
        Cliente::create($request->validated());
        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso.');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->validated());
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente removido com sucesso.');
    }
}
