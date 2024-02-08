<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("candidato.php");
include("candidatodao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(isset($_POST["acao"])){	
	if($_POST["acao"]=="listarcandidato"){
		$candidato = new Candidato();
		$candidatoDao = new CandidatoDAO($conexao);
		if(!is_numeric($_POST['candidato'])){
			$candidato->setNome($_POST['candidato']);
		}else{
			$candidato->setIdCandidato($_POST['candidato']);
		}
		$query = $candidatoDao->consultarCandidato($candidato);
		while($resultset = $candidatoDao->listarCandidato($query))
		{
		   $data[] = [
			"id" => $resultset["idcandidato"], 
			"value" => $resultset["idcandidato"]." - ".$resultset["nome"]];
		}
	   echo json_encode($data);
	}

	if($_POST["acao"]=="listarcandidatodocumentos"){
		$candidato = new Candidato();
		$candidatoDao = new CandidatoDAO($conexao);
		if($_POST["idcandidato"]>0){
			$candidato->setIdCandidato($_POST["idcandidato"]);
		}
		if(isset($_POST["rg"])){
			$candidato->setRg($_POST["rg"]);
		}
		if(isset($_POST["cpf"])){
			$candidato->setCpf($_POST["cpf"]);
		}
		if(isset($_POST["cnpj"])){
			$candidato->setCnpj($_POST["cnpj"]);
		}
		$query = $candidatoDao->consultarDocumentos($candidato);
		if($candidatoDao->getTotalRegistros($query)>0){
			echo 1;
		}else{
			echo 0;
		}
	}

	if($_POST["acao"]=="gravar"){
		$candidato = new Candidato();
		$candidatoDao = new CandidatoDAO($conexao);
		$candidato->setIdCandidato($_POST["idcandidato"]);
		$candidato->setNome($_POST["nome"]);
		$candidato->setEndereco($_POST["endereco"]);
		$candidato->setNumero($_POST["numero"]);
		$candidato->setBairro($_POST["bairro"]);
		$candidato->setCep($_POST["cep"]);
		$candidato->setIdPais($_POST["idpais"]);
		$candidato->setIdEstado($_POST["idestado"]);
		$candidato->setIdCidade($_POST["idcidade"]);
		$candidato->setEmail($_POST["email"]);
		$candidato->setRg($_POST["rg"]);
		$candidato->setCpf($_POST["cpf"]);
		$candidato->setCnpj($_POST["cnpj"]);
		$candidato->setTelefone($_POST["telefone"]);
		$candidato->setCelular($_POST["celular"]);
		$candidato->setObs($_POST["obs"]);
		if($candidato->getIdCandidato()>0){
			$candidatoDao->atualizarCandidato($candidato);	
		}else{
			$candidatoDao->inserirCandidato($candidato);
		}	
		header("Location:candidatolista.php");	
	}

	if($_POST["acao"]=="excluir"){
		$candidato = new Candidato();
		$candidatoDao = new CandidatoDAO($conexao);
		$candidato->setIdCandidato($_POST["idcandidato"]);
		$candidatoDao->deletarCandidato($candidato);
		header("Location:candidatolista.php");
	}
}

$conexao->fecharConexao();
?>