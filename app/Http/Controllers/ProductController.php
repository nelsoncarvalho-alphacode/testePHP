<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    public function __construct(
        protected Product $product,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public static function index()
    {
        $products = Product::all();
        return view('pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('pages.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            Product::create([
                'name' => $request['name'],
                'barCode' => $request['barCode'],
                'value' => $request['value'],
                'amount' => $request['amount']
            ]);
            DB::commit();
            return redirect()->route('create_product')->with('success', 'Produto Cadastrado!');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('create_product')->with('error', 'Erro ao cadastrar produto, reviser os campos.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $name = $request->name;
        $barCode = $request->barCode;
        $value = $request->value;
        if (!empty($name)) {
            $products = Product::getProductByName($name);
        } elseif (!empty($barCode)) {
            $products = Product::getProductByCpf($barCode);
        } elseif (!empty($value)) {
            $products = Product::getProductByEmail($value);
        } else {
            $products = Product::all() ?? [];
        }
        return view('pages.product.index', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
            $product = $this->product->find($request->id);
            $product->fill($request->input());
            $product->save();
            DB::commit();
            return redirect()->route('list_product')->with('success', 'Cliente Cadastrado!');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('list_product')->with('error', 'Erro ao editar produto.');
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
            $product = Product::findOrFail($id);
            $orders = PurchaseRequest::getOrdersByProductWithStatusOpem($id)->count();
            if ($orders){
                return redirect()->route('list_product')->with('error', 'Existe pedidos EM ABERTO para esse produto.');
            }
            $product->delete();
            DB::commit();
            return redirect()->route('list_product')->with('success', 'Produto Excluido.');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('list_product')->with('error', 'Não foi possivel excluir o produto.');
        }
    }
}
