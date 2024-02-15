<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("vaga.php");
include("vagadao.php");
include("vagaCandidato.php");
include("vagaCandidatodao.php");


$conexao = new Conexao();
$conexao->abrirConexao();

if(isset($_POST["acao"])){
	
	if($_POST["acao"]=="gravar"){
		$vaga = new Vaga();
		$vagaDao = new VagaDAO($conexao);
		$vaga->setIdVaga($_POST["idvaga"]);
		$vaga->setDescricao($_POST["descricao"]);
		$vaga->setIdTipoVaga($_POST["idtipovaga"]);
		$vaga->setAtiva($_POST["ativa"]);
		if($vaga->getIdVaga()>0){
			$vagaDao->atualizarVaga($vaga);	
		}else{
			$vagaDao->inserirVaga($vaga);
		}	
		header("Location:vagalista.php");	
	}

	if($_POST["acao"]=="excluir"){
		$vaga = new Vaga();
		$vagaDao = new VagaDAO($conexao);
		$vaga->setIdVaga($_POST["idvaga"]);
		$vagaDao->deletarVaga($vaga);    
		header("Location:vagalista.php");
	}
	
	if($_POST["acao"]=="excluircandidatura"){
		$vagaCandidato = new VagaCandidato();
		$vagaCandidatoDao = new VagaCandidatoDAO($conexao);
		$vagaCandidato->setIdVagaCandidato($_POST["idvagacandidato"]);
		$vagaCandidatoDao->deletarVagaCandidato($vagaCandidato);    
		header("Location:vagalista.php");
	}
}

$conexao->fecharConexao();
?>