<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("nivelacesso.php");
include("nivelacessodao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(isset($_POST["acao"])){
	if($_POST["acao"]=="gravar"){
		$nivelAcesso = new NivelAcesso();
		$nivelAcessoDao = new NivelAcessoDAO($conexao);
		$nivelAcesso->setIdNivelAcesso($_POST["idnivelacesso"]);
		$nivelAcesso->setNivelAcesso($_POST["nivelacesso"]);
		if($nivelAcesso->getIdNivelAcesso()>0){
			$nivelAcessoDao->atualizarNivelAcesso($nivelAcesso);	
		}else{
			$nivelAcessoDao->inserirNivelAcesso($nivelAcesso);
		}	
		header("Location:nivelacessolista.php");	
	}

	if($_POST["acao"]=="excluir"){
		$nivelAcesso = new NivelAcesso();
		$nivelAcessoDao = new NivelAcessoDAO($conexao);
		$nivelAcesso->setIdNivelAcesso($_POST["idnivelacesso"]);
		$nivelAcessoDao->deletarNivelAcesso($nivelAcesso);
		header("Location:nivelacessolista.php");
	}
} 
$conexao->fecharConexao();
?>