<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;
use App\Models\CandidatoVaga;

class CandidatoController extends Controller
{
    public function candidatos(){

        $candidatos = Candidato::all();
        return $candidatos;

    }

    public function candidato($candidato_id){

        $candidato = Candidato::where('id', $candidato_id)->select('nome', 'email', 'resumo')->first();
        return $candidato;

    }

    public function cadastro($dados){
        
        $candidato = new Candidato();

        $candidato->nome = $dados['nome'];
        $candidato->email = $dados['email'];
        $candidato->resumo = $dados['resumo'];
        $candidato->senha = password_hash($dados['senha'],  PASSWORD_BCRYPT);
        $candidato->save();

        $message = [
            'message' => 'Candidato cadastrado com sucesso',
            'user_id' => $candidato->id
        ];

        return $message;

    }

    public function login($dados){

        $candidato = Candidato::where('email', $dados['email'])->select('id', 'nome', 'email', 'senha')->first();
        
        if(empty($candidato)){
            $message = ['message' => 'Usuário não encontrado'];
            return $message;
        }

        if(!password_verify($dados['senha'], $candidato->senha)){
            $message = ['message' => 'Credenciais incorretas'];
            return $message;
        }
        
        else {
            
            $index_nome = strpos($candidato->nome, ' ');
            $candidato_nome = substr($candidato->nome, 0, $index_nome);

            $message = [
                'message' => 'Seja bem-vindo(a) de volta ' . $candidato_nome, 
                'user_id' => $candidato->id
            ];
            
            return $message;
        }

    }

    public function editar($dados){

        $candidato = Candidato::find($dados['id']);

        if(empty($candidato)){
            $message = ['message' => 'Usuário não encontrado'];
            return $message;
        }

        if(!empty($dados['novo_nome']))
            $candidato->nome = $dados['novo_nome'];
        if(!empty($dados['novo_email']))
            $candidato->email = $dados['novo_email'];
        if(!empty($dados['novo_resumo']))
            $candidato->resumo = $dados['novo_resumo'];
        if(!empty($dados['nova_data_nascimento']))
            $candidato->data_nascimento = $dados['novo_data_nascimento'];

        $candidato->save();

        $message = ['message' => 'Seus dados foram atualizados com sucesso'];
        return $message;
        
    }

    public function excluir_conta($id){

        $candidato = Candidato::find($id);

        if(empty($candidato)){
            $message = ['message' => 'Usuário não encontrado'];
            return $message;
        }

        $candidaturas = CandidatoVaga::where('candidato', $candidato->id)->get();

        foreach($candidaturas as $candidatura){
            $candidatura->delete();
        }
    
        $candidato->delete();

        $message = ['message' => 'Sua conta foi removida do sistema'];
        return $message;

    }


}
