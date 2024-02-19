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

    public function allClientes(){
        return Cliente::all();
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

        $validated = $validator->validated();

        $cliente_email_exists = Cliente::where('email', $validated['email'])->first();
        $cliente_cpf_exists = Cliente::where('cpf', $validated['cpf'])->first();
        
        if($cliente_cpf_exists){
            return $this->error("Este cpf já está cadastrado", 400);
        }

        if($cliente_email_exists){
            return $this->error("Este email já está cadastrado", 400);
        }

        $created = Cliente::create($validated);
        
        if($created){
            return $this->response("Cliente cadastrado com sucesso", 201, $created);
        }
    }

    public function destroy(int $id){
        $cliente = Cliente::find($id);

        if(!$cliente){
            return $this->response("Cliente não encontrado", 404);
        }
        
        $deleted = $cliente->delete();
        
        if($deleted){
            return $this->response("Cliente deletado com sucesso", 200);
        }

        return $this->response("Falha ao deletar cliente", 400);
    }

    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'cpf' => 'required|max:11',
            'email' => 'required'
        ]);

        if($validator->fails()){
            return $this->error("Dados inválidos", 422, $validator->errors());
        }
        
        $validated = $validator->validated();

        $cliente_email_exists = Cliente::where('email', $validated['email'])->first();
        $cliente_cpf_exists = Cliente::where('cpf', $validated['cpf'])->first();
        
        if($cliente_cpf_exists){
            if($cliente_cpf_exists->id != $id) return $this->error("Este cpf já está cadastrado", 400);
        }

        if($cliente_email_exists){
            if($cliente_email_exists->id != $id) return $this->error("Este email já está cadastrado", 400);
        }
        
        $updated = Cliente::find($id)->update([
            'nome' => $validated['nome'],
            'cpf' => $validated['cpf'],
            'email' => $validated['email']
        ]);
        
        if($updated){
            return $this->response("Cliente atualizado com sucesso", 200);
        }
        return $this->error("Falha ao atualiizar cliente", 400);
    }
}
