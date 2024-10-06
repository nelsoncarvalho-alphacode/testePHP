<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vagas;
use App\Models\VagasRequisitos;
use App\Models\TipoContrato;
use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\CandidatoVaga;

class VagasController extends Controller
{
    public function vagas(){

        $vagas = Vagas::where('ativa', true)->get();
        
        foreach($vagas as $vaga){
            $empresa = Empresa::where('id', $vaga->empresa)->select('nome')->first();
            $tipo_contrato = TipoContrato::where('id', $vaga->tipo_contrato)->select('tipo')->first();
            $vaga->empresa = $empresa->nome;
            $vaga->tipo_contrato = $tipo_contrato->tipo;
        }
        
        return $vagas;

    }

    public function vaga($vaga_id){

        $vaga = Vagas::find($vaga_id);
        return $vaga;

    }

    public function empresa_vagas($empresa_id){

        $vagas = Vagas::where('empresa', $empresa_id)->get();
        
        foreach($vagas as $vaga){
            $tipo_contrato = TipoContrato::where('id', $vaga->tipo_contrato)->select('tipo')->first();
            $vaga->tipo_contrato = $tipo_contrato->tipo;
        }
        
        return $vagas;

    }

    public function cadastro($dados){
        
        $vaga = new Vagas();

        $vaga->titulo = $dados['titulo'];
        $vaga->descricao = $dados['descricao'];
        $vaga->ativa = $dados['ativa'];
        $vaga->empresa = $dados['empresa']; 
        
        $tipo_contrato = $dados['tipo_contrato'];
        $tipo_contrato = TipoContrato::where('tipo', $tipo_contrato)->first();
        
        $vaga->tipo_contrato = $tipo_contrato->id;
        $vaga->save();

        return 'Vaga cadastrada com sucesso';

    }

    

    public function editar($dados){

        $vaga = Vagas::find($dados['id']);

        if(empty($vaga)){
            $message = ['message' => 'Vaga não encontrada'];
            return $message;
        }
        
        if(!empty($dados['novo_titulo']))
            $vaga->titulo = $dados['novo_titulo'];
        if(!empty($dados['nova_descricao']))
            $vaga->descricao = $dados['nova_descricao'];
        if(!empty($dados['ativa']) || $dados['ativa'] == 0)
            $vaga->ativa = (int) $dados['ativa'];

        if(!empty($dados['novo_tipo_contrato'])){
            $tipo_contrato = TipoContrato::where('tipo', $dados['novo_tipo_contrato'])->first();
            $vaga->tipo_contrato = $tipo_contrato->id;
        }

        $vaga->save();

        $message = ['message' => 'Vaga atualizada com sucesso'];
        return $message;
        
    }

    public function excluir_vaga($vaga_id){

        $vaga = Vagas::find($vaga_id);
        $candidaturas = CandidatoVaga::where('vaga', $vaga_id)->get();

        if(empty($vaga)){
            $message = ['message' => 'Vaga não encontrada'];
            return $message;
        }

        foreach($candidaturas as $candidatura){
            $candidatura->delete();
        }

        $vaga->delete();

        $message = ['message' => 'Vaga removida do sistema'];
        return $message;

    }

    public function candidatar($dados){

        $vaga = Vagas::find($dados['vaga']);
        $candidato = Candidato::find($dados['candidato']);

        if(empty($vaga))
            return 'Vaga não encontrada';

        if(empty($candidato))
            return 'Candidato não encontrado';

        $candidato_vaga = new CandidatoVaga();
        $candidato_vaga->vaga = $vaga->id;
        $candidato_vaga->candidato = $candidato->id;
        $candidato_vaga->save();
      
        return 'Candidatura enviada';
        
    }

    public function candidatos_vagas($id){

        $candidato = Candidato::find($id);

        if(empty($candidato)){
            $message = ['message' => 'Candidato não encontrado'];
            return $message;
        }

        $vagas_candidatadas = CandidatoVaga::where('candidato', $candidato->id)->get();
 

        foreach($vagas_candidatadas as $vaga_candidatada){
            $vaga = Vagas::find($vaga_candidatada->vaga);
            $empresa = Empresa::where('id', $vaga->empresa)->first();
            $tipo_contrato = TipoContrato::where('id', $vaga->tipo_contrato)->first();
           
            $vaga_candidatada->titulo = $vaga->titulo;
            $vaga_candidatada->descricao = $vaga->descricao;
            $vaga_candidatada->empresa = $empresa->nome;
            $vaga_candidatada->tipo_contrato = $tipo_contrato->tipo;
         
        }

        return $vagas_candidatadas;

    }

    public function remover_candidatura($dados){

        $vaga = Vagas::find($dados['vaga']);
        $candidato = Candidato::find($dados['candidato']);

        if(empty($vaga)){
            $message = ['message' => 'Vaga não encontrada'];
            return $message;
        }

        if(empty($candidato)){
            $message = ['message' => 'Candidato não encontrado'];
            return $message;
        }

        CandidatoVaga::where('vaga', $vaga->id)->delete();

        $message = ['message' => 'Candidatura removida'];
        return $message;

    }

}
