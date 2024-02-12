<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProductController extends Controller
{
    public function index () {
        $products = Produto::paginate(20);

        return view('produtos.list', ['products' => $products]);
    }

    public function create(){
        return view('produtos.create');
    }

    public function store(Request $request, Produto $produto){
        $data = $request->all();

        $produto->create($data);

        return redirect()->route('produtos.list');
    }

    public function destroy(string|int $id){
        if(!$product = Produto::find($id)){
            return back();
        }

        $product->delete();

        return redirect()->route('produtos.list');
    }

    public function edit(Produto $product, string|int $id){
        if(!$product = $product->where('id', $id)->first()){
            return back();
        }

        return view('produtos.edit', compact('product'));
    }

    public function update(Request $request, Produto $product, string|int $id){
        if(!$product = $product->find($id)){
            return back();
        }

        $product->update($request->all());

        return redirect()->route('produtos.list');
    }
}
