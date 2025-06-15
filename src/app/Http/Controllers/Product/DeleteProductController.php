<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DeleteProductController extends Controller
{
    private $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function delete(Request $request, string $id)
    {
        try {
            $this->product->remove($id);
            return response()->json(['message' => 'Produto deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar produto: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
