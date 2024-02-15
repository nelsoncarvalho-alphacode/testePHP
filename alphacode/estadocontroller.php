<?php
include("administracao/conexao.php");
include("estado.php");
include("estadodao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(isset($_POST["acao"])){
	if($_POST["acao"]=="listarestado"){
		$estado = new Estado();
		$estadoDao = new EstadoDAO($conexao);
		if(isset($_POST["idpais"])){
				$estado->setIdPais($_POST["idpais"]);
		}        
		$query = $estadoDao->consultarEstado($estado);
		while($resultset = $estadoDao->listarEstado($query))
		{
			$data[] = [
			"idestado" => $resultset["idestado"],
			"sigla" => $resultset["sigla"],
			"estado" => $resultset["estado"]    ];
		}
	   echo json_encode($data);
	}
	
	if($_POST["acao"]=="listarestadosigla"){
		$estado = new Estado();
		$estadoDao = new EstadoDAO($conexao);
		if($_POST["idestado"]>0){
			$estado->setIdEstado($_POST["idestado"]);
		}	
		if(isset($_POST["sigla"])){
			$estado->setSigla(strtoupper($_POST["sigla"]));
		}
		$query = $estadoDao->consultarEstadoSigla($estado);
		if($estadoDao->getTotalRegistros($query)>0){
			echo 1;
		}else{
			echo 0;
		}
	}

	if($_POST["acao"]=="gravar"){
		$estado = new Estado();
		$estadoDao = new EstadoDAO($conexao);
		$estado->setIdEstado($_POST["idestado"]);
		$estado->setSigla(strtoupper($_POST["sigla"]));
		$estado->setEstado($_POST["estado"]);
		$estado->setIdPais($_POST["idpais"]);
		if($estado->getIdEstado()>0){
			$estadoDao->atualizarEstado($estado);	
		}else{
			$estadoDao->inserirEstado($estado);
		}	
		header("Location:estadolista.php");	
	}

	if($_POST["acao"]=="excluir"){
		$estado = new Estado();
		$estadoDao = new EstadoDAO($conexao);
		$estado->setIdEstado($_POST["idestado"]);
		$estadoDao->deletarEstado($estado);
		header("Location:estadolista.php");
	}
} 
$conexao->fecharConexao();
?>