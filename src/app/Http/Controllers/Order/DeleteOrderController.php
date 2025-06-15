<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DeleteOrderController extends Controller
{
    private $order;

    public function __construct() {
        $this->order = new Order();
    }

    public function delete(Request $request, string $id)
    {
        try {
            $this->order->remove($id);
            return response()->json(['message' => 'Pedido deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar pedido: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
