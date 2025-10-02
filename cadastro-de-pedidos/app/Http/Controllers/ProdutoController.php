<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $allowed = ['id', 'codigo_barras', 'nome', 'valor_unitario', 'created_at', 'updated_at'];

        $query = Produto::query();

        foreach ($allowed as $field) {
            $value = $request->get($field);
            if ($value !== null && $value !== '') {
                if ($field === 'id') {
                    $query->where($field, $value);
                } elseif ($field === 'valor_unitario') {
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

        $produtos = $query->paginate(20)->withQueryString();

        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(ProdutoRequest $request)
    {
        Produto::create($request->validated());
        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(ProdutoRequest $request, Produto $produto)
    {
        $produto->update($request->validated());
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}
