<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use App\Models\Categorie;

class PurchaseOrderController extends Controller
{
    private function purchaseOrderNotFound() {
        return redirect()->route('purchase_orders.index')->with('error', 'Pedido não encontrado.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $orders = PurchaseOrder::getOrders($perPage, $sort, $direction);

        if ($orders->isEmpty()) {
            $orders = null;
        }

        return view('orders.index', compact('orders', 'direction', 'sort', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $categories = Categorie::getCategories();

        if ($categories->isEmpty()) {
            return redirect()->route('purchase_orders.index')->with('error', 'Nenhuma categoria encontrada.');
        }
        
        $products = Product::getProductsForCategorie($categories->first()->id);

        return view('orders.create', compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados do formulário
            $this->validateFormData($request);

            // Inicia uma transação
            DB::beginTransaction();

            $order = $this->createPurchaseOrder($request);

            $this->createPurchaseOrderItems($order, $request->input('product_list_data'));

            // Commit da transação
            DB::commit();

            // Redirecionar de volta à página de listagem de ordens de compra com uma mensagem de sucesso
            return redirect()->route('purchase_orders.index')->with('success', 'Pedido criado com sucesso.');
        } catch (ModelNotFoundException $e) {

            return $this->purchaseOrderNotFound();
        } catch (\Illuminate\Validation\ValidationException $e) {

            // Redireciona de volta ao formulário com erros de validação
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {

            // Em caso de falha, reverte a transação
            DB::rollback();
            
            // Lida com exceções ou erros durante o processo
            return redirect()->back()->with('error', 'Ocorreu um erro ao criar a ordem de compra.');
        }
    }

    private function createPurchaseOrder(Request $request)
    {
        $orderNumber = strtoupper('PED-' . uniqid());
        return PurchaseOrder::createPurchaseOrder($request, $orderNumber);
    }

    private function createPurchaseOrderItems($order, $productListData)
    {
        $productList = json_decode($productListData);
        PurchaseOrderItem::createPurchaseOrderItems($order->id, $productList);
    }

    // Métodos auxiliares
    private function validateFormData(Request $request)
    {
        $request->merge([
            'total' => str_replace(',', '.', str_replace(['R$ ', ','], '', $request->input('total')))
        ]);

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|string|max:255',
            'total' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:45',
            'order_date' => 'required|date',
            'product_list_data' => 'required|string|min:3',
        ], [
            'client_id.*' => 'O ID do cliente é obrigatório e deve ser válido.',
            'status.*' => 'O status é obrigatório e deve ser uma string com no máximo 255 caracteres.',
            'total.*' => 'O total é obrigatório e deve ser um número maior ou igual a 0.01.',
            'payment_method.*' => 'O método de pagamento é obrigatório e deve ser uma string com no máximo 45 caracteres.',
            'order_date.*' => 'A data do pedido é obrigatória e deve estar em um formato válido.',
            'product_list_data.*' => 'Os dados da lista de produtos são obrigatórios e devem ter no mínimo 3 caracteres.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Buscar a ordem de compra pelo ID
            $purchaseOrder = PurchaseOrder::withTrashed()->findOrFail($id);

            // Retornar a view com os detalhes da ordem de compra
            return view('orders.show', compact('purchaseOrder'));
        } catch (ModelNotFoundException $e) {
            return $this->purchaseOrderNotFound();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            // Buscar a ordem de compra pelo ID
            $purchaseOrder = PurchaseOrder::withTrashed()->findOrFail($id);

            // Buscar as categorias
            $categories = Categorie::getCategories();

            if ($categories->isEmpty()) {
                return redirect()->route('purchase_orders.index')->with('error', 'Nenhuma categoria encontrada.');
            }

            // Buscar os produtos da primeira categoria
            $products = Product::getProductsForCategorie($categories->first()->id);

            // Buscar os itens da ordem de compra com eager loading
            $purchaseOrderItems = $purchaseOrder->items;

            // Retornar a view do formulário de edição de ordem de compra com os itens
            return view('orders.edit', compact('purchaseOrder', 'categories', 'products', 'purchaseOrderItems'));
        } catch (ModelNotFoundException $e) {

            return redirect()->route('purchase_orders.index')->with('error', 'Pedido não encontrado.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validação dos dados do formulário
            $this->validateFormData($request);

            // Inicia uma transação
            DB::beginTransaction();

            // Atualiza os dados principais do pedido
            $this->updatePurchaseOrder($request, $id);

            // Processa a lista de produtos
            $productList = json_decode($request->input('product_list_data'), true);

            // Atualiza os itens do pedido
            $this->updatePurchaseOrderItems($id, $productList);

            // Commit da transação
            DB::commit();

            // Redirecionar de volta à página de listagem de ordens de compra com uma mensagem de sucesso
            return redirect()->route('purchase_orders.index')->with('success', 'Pedido atualizado com sucesso.');
        } catch (ModelNotFoundException $e) {

            return $this->purchaseOrderNotFound();
        } catch (\Exception $e) {

            // Em caso de falha, reverte a transação
            DB::rollback();

            // Redireciona de volta com uma mensagem de erro
            return redirect()->route('purchase_orders.index')->with('error', 'Erro ao atualizar o pedido.');
        }
    }

    protected function updatePurchaseOrder(Request $request, string $id)
    {
        PurchaseOrder::where('id', $id)->update($request->only(['client_id', 'status', 'total', 'payment_method', 'order_date']));
    }

    protected function updatePurchaseOrderItems(string $id, array $productList)
    {
        $productIds = collect($productList)->pluck('orderId')->filter();

        // Remove os itens que não estão mais na lista
        PurchaseOrderItem::where('purchase_order_id', $id)
            ->whereNotIn('id', $productIds)
            ->delete();

        // Atualiza ou insere os itens existentes
        foreach ($productList as $product) {
            PurchaseOrderItem::updateOrCreate(
                ['id' => $product['orderId']], // condição de atualização
                [
                    'purchase_order_id' => $id,
                    'product_id' => $product['id'],
                    'product_name' => $product['name'],
                    'unit_price' => $product['price'],
                    'quantity' => $product['quantity']
                ]
            );
        }
    }

    public function destroy(string $id)
    {
        try {
            $order = PurchaseOrder::withTrashed()->findOrFail($id);
            $order->forceDelete();

            return redirect()->route('purchase_orders.index')->with('success', 'Pedido excluído com sucesso.');
        } catch (ModelNotFoundException $e) {
            return $this->purchaseOrderNotFound();
        } catch (\Exception $e) {
            return redirect()->route('purchase_orders.show_deleted')->with('error', 'Erro ao excluir pedido.');
        }
    }

    public function softDeleted(string $id)
    {
        try {
            $order = PurchaseOrder::find($id);
            $order->delete();
    
            return redirect()->route('purchase_orders.index')->with('success', 'Pedido deletado com sucesso');
        } catch (ModelNotFoundException $e) {

            return $this->purchaseOrderNotFound();
        } catch (\Exception $e) {

            return redirect()->route('purchase_orders.index')->with('error', 'Erro ao deletar pedidp.');
        }
    }

    public function showDeleted(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 20);
            $sort = $request->input('sort', 'id');
            $direction = $request->input('direction', 'asc');

            $orders = PurchaseOrder::getOrdersDeleted($perPage, $sort, $direction);

            if ($orders->isEmpty()) {
                return redirect()->route('purchase_orders.index')->with('error', 'Sem pedidos deletado.');
            }

            return view('orders.showDeleted', compact('perPage', 'orders', 'direction', 'sort'));
        } catch (ModelNotFoundException $e) {

            return $this->purchaseOrderNotFound();
        }
    }

    public function restore(string $id)
    {
        try {
            $order = PurchaseOrder::withTrashed()->find($id);
            $order->restore();
    
            return redirect()->route('purchase_orders.index')->with('success', 'Pedido restaurado com sucesso');
        } catch (ModelNotFoundException $e) {

            return $this->purchaseOrderNotFound();
        } catch (\Exception $e) {

            return redirect()->route('produpurchase_orderscts.index')->with('error', 'Erro ao restaurar pedidp.');
        }
    }
}
