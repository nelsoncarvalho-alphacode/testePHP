<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index(Request $request)
    {
        $orderRepository = new OrderRepository($this->order);

        if($request->has('search')){

            $orderRepository->filter($request->filter);

            return response()->json($orderRepository->getResult(), 200);
        } else {
            $orders = $this->order->get();

            return response()->json($orders, 200);
        }
    }

    public function store(Request $request)
    {
        // criando o pedido
        $order = $this->order->create([
            'client_id' => $request->input('client_id'),
            'status' => $request->input('status'),
            'order_date' => date("Y-m-d")
        ]);

        $items = $request['items'];

        foreach($items as $item){
            $orderItem = new OrderItem([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity']
            ]);
            // criando os items que pertencem a cada pedido
            $order->items()->save($orderItem);
        }

        return response()->json(['message' => 'Pedido cadastrado com sucesso!'], 201);
    }

    public function show(string $id)
    {
        $order = $this->order->find($id);
        if($order === null){
            return response()->json(['erro' => 'O pedido informado não existe!'], 401);
        }

        return $order;
    }

    public function update(Request $request, string $id)
    {
        $order = $this->order->find($id);
        if($order === null){
            return response()->json(['erro' => 'O pedido informado não existe!'], 401);
        }

        $data = $request->all();
        $order->update($data);

        $items = $request['items'];

        foreach($items as $item){
            $orderItem = new OrderItem([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity']
            ]);
        }

        $order->items()->update($orderItem);

        return response()->json(['message' => 'Pedido atualizado com sucesso'], 200);
    }

    public function destroy(string $id)
    {
        $order = $this->order->find($id);
        if($order === null){
            return response()->json(['erro' => 'O pedido informado não existe!'], 401);
        }

        $order->delete();
    }
}
