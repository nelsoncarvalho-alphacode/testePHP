<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Validator;
use App\Traits\HttpResponses;

class ProdutoController extends Controller
{
    use HttpResponses;

    public function index(){
        return Produto::paginate(20);
    }

    public function allProducts(){
        return Produto::all();
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'cod_barras' => 'required',
            'valor' => 'required|numeric',
            'qtd_prod' => 'nullable'
        ]);

        if($validator->fails()){
            return $this->error("Dados inválidos", 422, $validator->errors());
        }

        $created = Produto::create($validator->validated());

        if($created){
            return $this->response("Produto cadastrado com sucesso", 201, $created);
        }
    }

    public function show($id){
        return $this->response("Produto encontrado com sucesso", 200, Produto::findOrFail($id));
    }

    public function destroy(int $id){
        $produto = Produto::find($id);

        if(!$produto){
            return $this->response("Produto não encontrado", 404);
        }
        
        $deleted = $produto->delete();
        
        if($deleted){
            return $this->response("Produto deletado com sucesso", 200);
        }

        return $this->response("Falha ao deletar produto", 400);
    }

    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'cod_barras' => 'required',
            'valor' => 'required|numeric',
            'qtd_prod' => 'nullable'
        ]);

        if($validator->fails()){
            return $this->error("Dados inválidos", 422, $validator->errors());
        }
        
        $validated = $validator->validated();
        
        $updated = Produto::find($id)->update([
            'nome' => $validated['nome'],
            'cod_barras' => $validated['cod_barras'],
            'valor' => $validated['valor'],
            'qtd_prod' => $validated['qtd_prod']
        ]);
        
        if($updated){
            return $this->response("Produto atualizado com sucesso", 200);
        }
        return $this->error("Falha ao atualiizar produto", 400);
    }
}
