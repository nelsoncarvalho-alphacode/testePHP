<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("tipovaga.php");
include("tipovagadao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(isset($_POST["acao"])){
	
	if($_POST["acao"]=="gravar"){
		$tipoVaga = new TipoVaga();
		$tipoVagaDao = new TipoVagaDAO($conexao);
		$tipoVaga->setIdTipoVaga($_POST["idtipovaga"]);
		$tipoVaga->setTipo($_POST["tipo"]);
		if($tipoVaga->getIdTipoVaga()>0){
			$tipoVagaDao->atualizarTipoVaga($tipoVaga);	
		}else{
			$tipoVagaDao->inserirTipoVaga($tipoVaga);
		}	
		header("Location:tipovagalista.php");	
	}

	if($_POST["acao"]=="excluir"){
		$tipoVaga = new TipoVaga();
		$tipoVagaDao = new TipoVagaDAO($conexao);
		$tipoVaga->setIdTipoVaga($_POST["idtipovaga"]);
		$tipoVagaDao->deletarTipoVaga($tipoVaga);    
		header("Location:tipovagalista.php");
	}
}

$conexao->fecharConexao();
?>