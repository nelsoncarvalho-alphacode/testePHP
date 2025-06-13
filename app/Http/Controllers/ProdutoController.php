<?php
namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\StoreProdutoRequest;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::query();
    
        if ($request->filled('search')) {
            $query->where('cod_barras', 'like', '%'.$request->search.'%')
                ->orWhere('nome', 'like', '%'.$request->search.'%')
                ->orWhere('valor_unitario', 'like', '%'.$request->search.'%');
        }
        
        $order = $request->input('order', 'id');
        $direction = $request->input('direction', 'asc');
        $query->orderBy($order, $direction);
        
        $produtos = $query->paginate(20);
        
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(StoreProdutoRequest $request)
    {
        $produto = Produto::create($request->validated());
        
        return redirect()
            ->route('produto.show', $produto->id)
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $data = $request->validate([
            'cod_barras' => 'required|string|max:20|unique:produtos,cod_barras,'.$produto->id,
            'nome' => 'required|string|max:100',
            'valor_unitario' => 'required|numeric|min:0.01',
        ]);
        $produto->update($data);
        
        return redirect()
            ->route('produtos.show', $produto->id)
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        if ($produto->pedidos()->exists()) {
            return redirect()
                ->route('produtos.index')
                ->with('error', 'Não é possível excluir produto com pedidos associados!');
        }
        
        $produto->delete();
        
        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}