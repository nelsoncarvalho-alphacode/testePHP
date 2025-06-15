<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CreateOrderController extends Controller
{
    private $order;

    public function __construct() {
        $this->order = new Order();
    }

    public function create(Request $request)
    {
        try{
            $request->validate([
                'client_id' => 'required|exists:App\Models\Client,id',
                'product_id' => 'required|exists:App\Models\Product,id',
                'quantity' => 'required|integer|min:1',
                'status' => ['required', 'regex:/^(pending|payed|canceled)$/'],
                'order_date' => ['required', Rule::date()->format('Y-m-d')],
                'discount' => 'nullable|regex:/^0\.\d{2}$/',
            ], [
                'client_id.required' => 'ID do cliente obrigatório.',
                'product_id.required' => 'ID do produto obrigatório.',
                'client_id.exists' => 'ID do cliente não existe.',
                'product_id.exists' => 'ID do produto não existe.',
                'quantity.required' => 'Quantidade obrigatória.',
                'quantity.integer' => 'Quantidade deve ser um número inteiro.',
                'quantity.min' => 'Quantidade deve ser pelo menos 1.',
                'status.required' => 'Status obrigatório.',
                'status.regex' => 'Status inválido. Deve ser um dos seguintes: pending, payed, canceled.',
                'order_date.required' => 'Data do pedido obrigatória.',
                'order_date.date' => 'Data do pedido inválida.',
                'discount.regex' => 'Desconto inválido.'
            ]);
        }catch(\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_BAD_REQUEST);
        }

        try{
            $data = $request->all();
            $this->order->create($data);

            return response()->json(['message' => 'Pedido criado com sucesso.'], Response::HTTP_CREATED);
        }catch(\Exception $e) {
            return response()->json(['error' => 'Erro ao criar pedido: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
