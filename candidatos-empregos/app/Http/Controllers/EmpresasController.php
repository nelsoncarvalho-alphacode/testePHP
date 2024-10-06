<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Vagas;
use App\Models\CandidatoVaga;
use App\Models\Candidato;

class EmpresasController extends Controller
{
    public function empresas(){

        $empresas = Empresa::all();
        return $empresas;

    }

    public function empresa($empresa_id){
        
        $empresa_dados = Empresa::where('id', $empresa_id)->select('nome', 'email', 'cnpj', 'descricao')->first();
        return $empresa_dados;
        
    }

    public function cadastro($dados){
        
        $empresa = new Empresa();
        $api_consulta_cnpj = 'https://www.receitaws.com.br/v1/cnpj/';
        
        $empresa_dados_publicos = file_get_contents($api_consulta_cnpj . $dados['cnpj']);
        $empresa_dados = json_decode($empresa_dados_publicos);

        if($empresa_dados->status != 'ERROR'){

            $empresa->nome = $empresa_dados->nome;
            $empresa->email = $empresa_dados->email;
            $empresa->senha = password_hash($dados['senha'],  PASSWORD_BCRYPT);
            $empresa->cnpj = $dados['cnpj']; 
            $empresa->descricao = $dados['descricao'];
            $empresa->save();
            
            $index_nome = strpos($empresa->nome, ' ');
            $empresa_nome = substr($empresa->nome, 0, $index_nome);

            $message = [
                'message' => 'Seja bem-vindo(a) ' . $empresa_nome,
                'user_id' => $empresa->id
            ];

            return $message;

        }

        else {
            $message = ['message' => 'CNPJ inválido'];
            return $message;
        }

    }

    public function login($dados){

        $empresa = Empresa::where('cnpj', $dados['cnpj'])->select('id', 'nome', 'email', 'senha')->first();
        
        if(empty($empresa)){
            $message = [ 'message' => 'Usuário não encontrado' ];
            return $message;
        }

        if(!password_verify($dados['senha'], $empresa->senha)){
            $message = [ 'message' => 'Credenciais incorretas'];
            return $message;
        }

        else {
            
            $index_nome = strpos($empresa->nome, ' ');
            $empresa_nome = substr($empresa->nome, 0, $index_nome);

            $message = [
                'message' => 'Seja bem-vindo(a) de volta ' . $empresa_nome, 
                'user_id' => $empresa->id
            ];
            
            return $message;
        }

    }

    public function editar($dados){

        $empresa = Empresa::find($dados['id']);

        if(empty($empresa))
            return 'Usuário não encontrado';
        
        if(!empty($dados['novo_nome']))
            $empresa->nome = $dados['novo_nome'];
        if(!empty($dados['novo_email']))
            $empresa->email = $dados['novo_email'];
        if(!empty($dados['nova_descricao']))
            $empresa->descricao = $dados['nova_descricao'];
        if(!empty($dados['novo_cnpj']))
            $empresa->cnpj = $dados['novo_cnpj'];

        $empresa->save();

        $message = ['message' => 'Seus dados foram atualizados com sucesso'];
        return $message;
        
    }

    public function excluir_conta($id){

        $empresa = Empresa::find($id);
        $vagas = Vagas::where('empresa', $empresa->id)->get();

        if(empty($empresa)){
            $message = ['message' => 'Usuário não encontrado'];
            return $message;
        }

        if(!empty($vagas)){

            foreach($vagas as $vaga){
                $candidatura = CandidatoVaga::where('vaga', $vaga->id)->first();
                if(!empty($candidatura))
                    $candidatura->delete();
                $vaga->delete();
            }
        }

        $empresa->delete();

        $message = ['message' => 'Sua conta foi removida do sistema'];
        return $message;

    }

    public function vaga_candidatos($dados){

        $empresa = Empresa::find($dados['empresa']);
        $vaga = Vagas::find($dados['vaga']);

        if(empty($empresa)){
            $message = ['message' => 'Empresa não encontrada'];
            return $message;
        }

        if(empty($vaga)){
            $message = ['message' => 'Vaga não encontrada'];
            return $message;
        }

        if($vaga->empresa != $empresa->id){
            $message = ['message' => 'Essa vaga não pertence a sua empresa'];
            return $message;
        }

        $candidatos = [];
        $candidaturas = CandidatoVaga::where('vaga', $vaga->id)->select('candidato')->get();

        foreach($candidaturas as $candidatura){
            $candidato = Candidato::find($candidatura->candidato);
            array_push($candidatos, $candidato);
        }

        return $candidatos;

    }

}
