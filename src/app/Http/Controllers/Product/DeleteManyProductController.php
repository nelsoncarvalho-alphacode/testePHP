<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteManyProductController extends Controller
{
   private $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function deleteMany(Request $request)
    {
        try{
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:products,id',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }



        try {
            $this->product->removeMany($request->ids);
            return response()->json(['message' => 'Produtos deletados com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar produtos: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
