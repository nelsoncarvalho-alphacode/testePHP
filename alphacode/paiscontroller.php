<?php
include("administracao/conexao.php");
include("pais.php");
include("paisdao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(isset($_POST["acao"])){
	if($_POST["acao"]=="gravar"){
		$pais = new Pais();
		$paisDao = new PaisDAO($conexao);
		$pais->setIdPais($_POST["idpais"]);
		$pais->setPais($_POST["pais"]);
		if($pais->getIdPais()>0){
			$paisDao->atualizarPais($pais);	
		}else{
			$paisDao->inserirPais($pais);
		}	
		header("Location:paislista.php");	
	}

	if($_POST["acao"]=="excluir"){
		$pais = new Pais();
		$paisDao = new PaisDAO($conexao);
		$pais->setIdPais($_POST["idpais"]);
		$paisDao->deletarPais($pais);
		header("Location:paislista.php");
	}
} 
$conexao->fecharConexao();
?>