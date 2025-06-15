<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UpdateOrderController extends Controller
{
    private $order;

    public function __construct() {
        $this->order = new Order();
    }

    public function update(Request $request, string $id)
    {

        try{
            $request->validate([
                'client_id' => 'exists:App\Models\Client,id',
                'product_id' => 'exists:App\Models\Product,id',
                'quantity' => 'integer|min:1',
                'status' => ['regex:/^(pending|payed|canceled)$/'],
                'order_date' => [Rule::date()->format('Y-m-d')],
                'discount' => 'nullable|regex:/^0\.\d{2}$/',
            ], [
                'client_id.exists' => 'ID do cliente não existe.',
                'product_id.exists' => 'ID do produto não existe.',
                'quantity.integer' => 'Quantidade deve ser um número inteiro.',
                'quantity.min' => 'Quantidade deve ser pelo menos 1.',
                'status.regex' => 'Status inválido. Deve ser um dos seguintes: pending, payed, canceled.',
                'order_date.date' => 'Data do pedido inválida.',
                'discount.regex' => 'Desconto inválido.'
            ]);
        }catch(\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_BAD_REQUEST);
        }

        try{
            $data = $request->all();
            return $this->order->updateData($id, $data);

            return response()->json(['message' => 'Pedido atualizado com sucesso.'], Response::HTTP_OK);
        }catch(\Exception $e) {
            return response()->json(['error' => 'Erro ao criar pedido: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}


