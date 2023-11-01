<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\PurchaseRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PurchaseRequestController extends Controller
{
    public function __construct(
        protected PurchaseRequest $purchaseRequest,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = PurchaseRequest::all();
        $products = Product::all();
        $clients = Client::all();
        $status = Status::all();
        return view('pages.purchase.index')->with([
            'orders' => $orders,
            'products' => $products,
            'status' => $status,
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $clients = Client::all();

        return view('pages.purchase.create')->with('products', $products)->with('clients', $clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($request->id_product);
            if ($request->amount_Buy > $product->amount) {
                return back();// msg informando que o estoque é insuficiente.
            }
            $request['id_status'] = 1;
            $request['value_unit'] = $product->value;
            $request['percentage_descount'] = $request->percentage_descount ?? 0;
            $price = $request->amount_Buy * $request['value_unit'];
            if ($request->percentage_descount > 0) {
                $descounte = $price * ($request->percentage_descount / 100);
            } else {
                $descounte = 0;
            }
            $request['amount_Buy_descount'] = $price - $descounte;

            $product['amount'] = $product->amount - $request->amount_Buy;
            if ($product->amount < 0) {
                return redirect()->route('create_purchase')->with('error', 'Não possui saldo suficiente em estoque.');
            }
            $product->save();
            PurchaseRequest::create($request->input());
            DB::commit();
            return redirect()->route('create_purchase')->with('success', 'Pedido criado com sucesso.');;
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('create_purchase')->with('error', 'Não foi possivel criar o pedido.');
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            DB::beginTransaction();
            $object = PurchaseRequest::findOrFail($id);
            $object['id_status'] = $status;
            if ($status == 3) {
                $product = Product::findOrFail($object->id_product);
                $product['amount'] = $product->amount + $object->amount_Buy;
                $product->save();
            }
            $object->save();
            DB::commit();
            return redirect()->route('list_purchase')->with('success', 'Produto Atualizado.');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('list_purchase')->with('error', 'Não foi possivel concluir alteração.');
        }
    }


    /**
     * Display the specified resource.
     */
    public
    function show(Request $request)
    {

        $clientFilter = $request->id_client;
        $productFilter = $request->id_product;
        $id_status = $request->id_status;
        if (!empty($clientFilter)) {
            $clients = Client::getClientByName($clientFilter);
            foreach ($clients as $client) {
                $orders = PurchaseRequest::getOrdersByClientId($client->id);
                foreach ($orders as $order) {
                    $purchaseResquests[] = $order;
                }
            }
        } elseif (!empty($productFilter)) {
            $products = Product::getProductByname($productFilter);
            foreach ($products as $aux_product) {
                $orders = PurchaseRequest::getOrdersByProductId($aux_product->id);
                foreach ($orders as $order) {
                    $purchaseResquests[] = $order;
                }
            }
        } elseif (!empty($id_status)) {
            $purchaseResquests = PurchaseRequest::getOrdersByStatus($id_status);
        } else {
            $purchaseResquests = PurchaseRequest::all() ?? [];
        }

        $orders = PurchaseRequest::all();
        $products = Product::all();
        $clients = Client::all();
        $status = Status::all();
        return view('pages.purchase.index')->with([
            'orders' => $purchaseResquests ?? [],
            'products' => $products ?? '',
            'status' => $status ?? [],
            'clients' => $clients ?? "",
            'id_statusFilter' => $id_status ?? [],
            'productFilter' => $productFilter ?? '',
            'clientFilter' => $clientFilter ?? '',

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($request->id_product);
            $order = PurchaseRequest::findOrFail($request->id);
            $productOld = Product::findOrFail($order->id_product);
            if ($productOld->id != $request->id_product) {
                $productOld['amount'] = $productOld->amount + $order->amount_Buy;
                $product['amount'] = $product->amount - $request->amount_Buy;
                if ($product->amount > 0) {
                    $productOld->save();
                    $product->save();
                } else {
                    return redirect()->route('list_purchase')->with('error', 'O produto selecionado não possui saldo suficiente em estoque.');
                }
            } else {
                $productOld['amount'] = $productOld->amount - ($request->amount_Buy - $order->amount_Buy);
                if ($productOld->amount >= 0) {
                    $productOld->save();
                } else {
                    return redirect()->route('list_purchase')->with('error', 'Não possui saldo suficiente em estoque.');
                }
            }

            $order['id_client'] = $request->id_client;
            $order['id_product'] = $request->id_product;
            $order['value_unit'] = $product['value'];
            $order['amount_Buy'] = $request->amount_Buy;
            $request['value_unit'] = $product->value;
            $request['percentage_descount'] = $request->percentage_descount ?? 0;
            $price = $request->amount_Buy * $request['value_unit'];
            if ($request->percentage_descount > 0) {
                $descounte = $price * ($request->percentage_descount / 100);
            } else {
                $descounte = 0;
            }
            $request['amount_Buy_descount'] = $price - $descounte;
            $product['amount'] = $product->amount - $request->amount_Buy;
            $product->save();
            DB::commit();

            return redirect()->route('list_purchase')->with('success', 'Pedido Atualizado..');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('list_purchase')->with('error', 'Não foi possivel atualizar o Pedido.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(string $id)
    {
        try {
            DB::beginTransaction();
        $object = PurchaseRequest::findOrFail($id);
        $object->delete();

            DB::commit();
            return redirect()->route('list_purchase')->with('success', 'Pedido excluido com sucesso.');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('list_purchase')->with('error', 'Não foi possivel excluir o Pedido.');
        }
    }
}
