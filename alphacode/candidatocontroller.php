<?php
include("administracao/conexao.php");
include("candidato.php");
include("candidatodao.php");
include("vagacandidato.php");
include("vagacandidatodao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(isset($_POST["acao"])){	
	if($_POST["acao"]=="gravar"){
		$candidato = new Candidato();
		$candidatoDao = new CandidatoDAO($conexao);
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
		$candidatoDao->inserirCandidato($candidato);
		
		$query = $candidatoDao->consultarUltimoCandidato();
 	    $resultsetcandidato = $candidatoDao->listarCandidato($query);
		
		$vagaCandidato = new VagaCandidato();
		$vagaCandidatoDao = new VagaCandidatoDAO($conexao);
		$vagaCandidato->setIdCandidato($resultsetcandidato["idcandidato"]);
		$vagaCandidato->setIdVaga($_POST["idvaga"]);
		
		$vagaCandidatoDao->inserirVagaCandidato($vagaCandidato);
		
		header("Location:candidaturafinalizada.php");	
	}
}

$conexao->fecharConexao();
?>