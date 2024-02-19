<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\HttpResponses;

use App\Models\Pedido;
use App\Models\Produto;

class PedidoController extends Controller
{
    use HttpResponses;
    
    public function index(){
        $pedidos = Pedido::with(['produto', 'cliente'])->paginate(20);
        return response()->json($pedidos);
    }

    public function allPedidos(){
        return Pedido::with(['produto', 'cliente'])->get();
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'produto_id' => 'required|numeric',
            'quantidade_prod_pedido' => 'required|numeric|min:1',
            'cliente_id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return $this->error("Dados inválidos", 422, $validator->errors());
        }

        $validated = $validator->validated();

        $estoque_produto = Produto::find($validated['produto_id']);

        if($estoque_produto->qtd_prod < 1 || $estoque_produto->qtd_prod < $validated['quantidade_prod_pedido']){
            return $this->error(
                "Infelizmente não temos em estoque esta quantidade para este produto no momento.",
                 400, $validator->errors());
        }

        $created = Pedido::create($validated);

        if($created){
            $qtd_prod_atualizada = ($estoque_produto->qtd_prod) - $validated['quantidade_prod_pedido'];

            $estoque_produto->update([
                'qtd_prod' => $qtd_prod_atualizada
            ]);
            return $this->response("Pedido cadastrado com sucesso", 201, $created);
        }

    }

    public function destroy(int $id){
        $pedido = Pedido::find($id);

        if(!$pedido){
            return $this->response("Pedido não encontrado", 404);
        }
        
        $deleted = $pedido->delete();
        
        if($deleted){
            return $this->response("Pedido deletado com sucesso", 200);
        }

        return $this->response("Falha ao deletar Pedido", 400);
    }

    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(), [
            'produto_id' => 'required|numeric|',
            'quantidade_prod_pedido' => 'required|numeric|min:1',
            'cliente_id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return $this->error("Dados inválidos", 422, $validator->errors());
        }

        $validated = $validator->validated();

        $pedido = Pedido::find($id);

        $mesmo_produto = $pedido->produto_id == $validated['produto_id'];

        $estoque_produto = Produto::find($validated['produto_id']);

        if($mesmo_produto){
            if($validated['quantidade_prod_pedido'] > $pedido->quantidade_prod_pedido){
                $diferenca_quantidade = $validated['quantidade_prod_pedido'] - $pedido->quantidade_prod_pedido;


                if($estoque_produto->qtd_prod < 1 || $estoque_produto->qtd_prod < $diferenca_quantidade){
                    return $this->
                        error(
                            "Infelizmente não temos em estoque esta quantidade para este produto no momento.",
                             400, $validator->errors());
                }

                $updated = $pedido->update([
                    'produto_id' => $validated['produto_id'],
                    'quantidade_prod_pedido' => $validated['quantidade_prod_pedido'],
                    'cliente_id' => $validated['cliente_id']
                ]);

                if($updated){
                    $qtd_prod_atualizada = ($estoque_produto->qtd_prod) - $diferenca_quantidade;
        
                    $estoque_produto->update([
                        'qtd_prod' => $qtd_prod_atualizada
                    ]);
                    return $this->response("Pedido atualizado com sucesso", 200);
                }
            } else{
                $updated = $pedido->update([
                    'produto_id' => $validated['produto_id'],
                    'quantidade_prod_pedido' => $validated['quantidade_prod_pedido'],
                    'cliente_id' => $validated['cliente_id']
                ]);
                
                if($updated){
                    return $this->response("Pedido atualizado com sucesso", 200);
                }
            }
        } else{
            if($estoque_produto->qtd_prod < 1 || $estoque_produto->qtd_prod < $validated['quantidade_prod_pedido']){
                return $this->error(
                    "Infelizmente não temos em estoque esta quantidade para este produto no momento.",
                     400, $validator->errors());
            }

            $updated = $pedido->update([
                'produto_id' => $validated['produto_id'],
                'quantidade_prod_pedido' => $validated['quantidade_prod_pedido'],
                'cliente_id' => $validated['cliente_id']
            ]);
            
            if($updated){
                $qtd_prod_atualizada = ($estoque_produto->qtd_prod) - $validated['quantidade_prod_pedido'];

                $estoque_produto->update([
                    'qtd_prod' => $qtd_prod_atualizada
                ]);
                return $this->response("Pedido atualizado com sucesso", 200);
            }
        }
    }
}
