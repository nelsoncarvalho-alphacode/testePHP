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

            $orderRepository->filterOrder($request->search);

            return response()->json($orderRepository->getResultPaginate(20), 200);
        } else {
            $orders = $this->order->with(['client', 'product'])->orderBy('created_at', 'desc')->paginate(20);

            return response()->json($orders, 200);
        }
    }

    public function store(OrderRequest $request)
    {
        $data = $request->all();
        //dd($data);
        // criando o pedido
        $this->order->create($data);

        return response()->json(['message' => 'Pedido cadastrado com sucesso!'], 201);
    }

    public function show(string $id)
    {
        $order = $this->order->with(['client', 'product'])->find($id);
        if($order === null){
            return response()->json(['erro' => 'O pedido informado não existe!'], 404);
        }

        return response()->json($order, 200);
    }

    public function update(Request $request, string $id)
    {
        $order = $this->order->find($id);
        if($order === null){
            return response()->json(['erro' => 'O pedido informado não existe!'], 404);
        }

        $data = $request->all();
        $order->update($data);

        return response()->json(['message' => 'Pedido atualizado com sucesso'], 200);
    }

    public function destroy(string $id)
    {
        $order = $this->order->find($id);
        if($order === null){
            return response()->json(['erro' => 'O pedido informado não existe!'], 404);
        }

        $order->delete();
    }

    public function getOrders()
    {
        $orders = $this->order->get();

        return response()->json($orders, 200);
    }
}
