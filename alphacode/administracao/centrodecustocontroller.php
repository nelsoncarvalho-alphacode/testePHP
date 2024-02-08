<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("centrodecusto.php");
include("centrodecustodao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(isset($_POST["acao"])){
	
	if($_POST["acao"]=="gravar"){
		$centroDeCusto = new CentroDeCusto();
		$centroDeCustoDao = new CentroDeCustoDAO($conexao);
		$centroDeCusto->setIdCentroDeCusto($_POST["idcentrodecusto"]);
		$centroDeCusto->setCentroDeCusto($_POST["centrodecusto"]);
		$centroDeCusto->setEndereco($_POST["endereco"]);
		$centroDeCusto->setNumero($_POST["numero"]);
		$centroDeCusto->setBairro($_POST["bairro"]);
		$centroDeCusto->setCep($_POST["cep"]);
		$centroDeCusto->setEmail($_POST["email"]);
		$centroDeCusto->setTelefone($_POST["telefone"]);
		if($centroDeCusto->getIdCentroDeCusto()>0){
			$centroDeCustoDao->atualizarCentroDeCusto($centroDeCusto);	
		}else{
			$centroDeCustoDao->inserirCentroDeCusto($centroDeCusto);
		}	
		header("Location:centrodecustolista.php");	
	}

	if($_POST["acao"]=="excluir"){
		$centroDeCusto = new CentroDeCusto();
		$centroDeCustoDao = new CentroDeCustoDAO($conexao);
		$centroDeCusto->setIdCentroDeCusto($_POST["idcentrodecusto"]);
		$centroDeCustoDao->deletarCentroDeCusto($centroDeCusto);
		header("Location:centrodecustolista.php");
	}
}

$conexao->fecharConexao();
?>