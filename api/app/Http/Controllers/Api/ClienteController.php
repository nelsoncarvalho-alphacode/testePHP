<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;
use App\Traits\HttpResponses;

class ClienteController extends Controller
{
    use HttpResponses;

    public function index(){
        return Cliente::paginate(20);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'cpf' => 'required|max:11',
            'email' => 'required'
        ]);

        if($validator->fails()){
            return $this->error("Dados inválidos", 422, $validator->errors());
        }

        $created = Cliente::create($validator->validated());

        if($created){
            return $this->response("Cliente cadastrado com sucesso", 201, $created);
        }
    }
}
