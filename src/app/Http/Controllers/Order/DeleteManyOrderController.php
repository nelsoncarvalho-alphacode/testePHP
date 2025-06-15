<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteManyOrderController extends Controller
{
   private $order;

    public function __construct() {
        $this->order = new Order();
    }

    public function deleteMany(Request $request)
    {
        try{
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:orders,id',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }



        try {
            $this->order->removeMany($request->ids);
            return response()->json(['message' => 'Pedidos deletados com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar pedidos: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
