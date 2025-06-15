<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class CreateProductController extends Controller
{
    private $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function create(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:100',
                'price' => 'required|regex:/^\d+(\.\d{1,2})$/',
                'barcode' => 'required|string|max:50|unique:products,barcode',
            ], [
                'name.required' => 'Nome obrigatório.',
                'name.max' => 'Nome muito longo.',
                'price.required' => 'Preço obrigatório.',
                'price.regex' => 'Preço deve ser um número decimal válido.',
                'barcode.required' => 'Código de barras obrigatório.',
                'barcode.max' => 'Código de barras muito longo.',
                'barcode.unique' => 'Código de barras já cadastrado.',
            ]);
        }catch(\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_BAD_REQUEST);
        }

        try{
            $data = $request->all();
            $this->product->create($data);

            return response()->json(['message' => 'Produto criado com sucesso.'], Response::HTTP_CREATED);
        }catch(\Exception $e) {
            return response()->json(['error' => 'Erro ao criar produto: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
