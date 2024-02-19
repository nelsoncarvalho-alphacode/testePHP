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
}
