<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\HttpResponses;

use App\Models\Pedido;

class PedidoController extends Controller
{
    use HttpResponses;
    
    public function index(){
        $pedidos = Pedido::with(['produto', 'cliente'])->paginate(20);
        return response()->json($pedidos);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'produto_id' => 'required|numeric',
            'quantidade_prod_pedido' => 'required|numeric',
            'cliente_id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return $this->error("Dados inválidos", 422, $validator->errors());
        }

        $created = Pedido::create($validator->validated());

        if($created){
            return $this->response("Pedido cadastrado com sucesso", 201, $created);
        }

    }
}
