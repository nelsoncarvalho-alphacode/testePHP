<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $productRepository = new ProductRepository($this->product);

        if($request->has('search')){

            $productRepository->filter($request->search);

            return response()->json($productRepository->getResultPaginate(20), 200);
        } else {
            $products = $this->product->paginate(20);

            return response()->json($products, 200);
        }
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $this->product->create($data);
        return response()->json(['message' => 'Produto cadastrado com sucesso!'], 201);
    }

    public function show(string $id)
    {
        $product = $this->product->find($id);
        if($product == null){
            return response()->json(['erro' => 'Produto informado não existe!'], 404);
        }

        return $product;
    }

    public function update(ProductRequest $request, string $id)
    {
        $product = $this->product->find($id);
        if($product == null){
            return response()->json(['erro' => 'Produto informado não existe!'], 404);
        }
        $data = $request->all();
        $product->update($data);
        return response()->json(['message' => 'Produto atualizado com sucesso!'], 200);
    }

    public function destroy(string $id)
    {
        $product = $this->product->find($id);
        if($product == null){
            return response()->json(['erro' => 'Produto informado não existe!'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Produto deletado com sucesso'], 200);
    }

    public function getProducts()
    {
        $products = $this->product->get();

        return response()->json($products, 200);
    }
}
