<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\OrderProduct;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('client')->get();
        return view('pages.orders.index', compact('orders'))->with('title', 'Listar Pedidos');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        return view('pages.orders.create', compact('clients', 'products'))->with('title', 'Registrar Pedido');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'order_status' => 'required|in:Open,Paid,Cancelled',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'order_number' => $this->generateOrderNumber(),
            'client_id' => $request->client_id,
            'order_status' => $request->order_status,
            'total_amount' => 0, // Placeholder, will be updated later
            'discount' => $request->discount ?? 0,
        ]);

        $totalAmount = 0;
        foreach ($request->products as $productData) {
            $product = Product::find($productData['product_id']);
            $orderProduct = new OrderProduct([
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'barcode' => $product->barcode,
                'unit_price' => $product->unit_price,
                'quantity' => $productData['quantity'],
            ]);
            $order->orderProducts()->save($orderProduct);
            $totalAmount += $product->unit_price * $productData['quantity'];
        }

        $order->update(['total_amount' => $totalAmount]);

        return redirect()->route('orders.index')->with('success', 'Pedido cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('client', 'orderProducts');
        return view('pages.orders.show', compact('order'))->with('title', 'View Order');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $clients = Client::all();
        $products = Product::all();
        $order->load('orderProducts');
        return view('pages.orders.edit', compact('order', 'clients', 'products'))->with('title', 'Edit Order');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'order_status' => 'required|in:Open,Paid,Cancelled',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order->update([
            'client_id' => $request->client_id,
            'order_status' => $request->order_status,
            'discount' => $request->discount ?? 0,
        ]);

        $order->orderProducts()->delete();

        $totalAmount = 0;
        foreach ($request->products as $productData) {
            $product = Product::find($productData['product_id']);
            $orderProduct = new OrderProduct([
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'barcode' => $product->barcode,
                'unit_price' => $product->unit_price,
                'quantity' => $productData['quantity'],
            ]);
            $order->orderProducts()->save($orderProduct);
            $totalAmount += $product->unit_price * $productData['quantity'];
        }

        $order->update(['total_amount' => $totalAmount]);

        return redirect()->route('orders.index')->with('success', 'Pedido atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pedido excluso com sucesso.');
    }

    /**
     * Generate the order number.
     */
    private function generateOrderNumber()
    {
        return Order::max('order_number') + 1;
    }
}
