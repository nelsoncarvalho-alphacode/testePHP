<?php
include("administracao/conexao.php");
include("cidade.php");
include("cidadedao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(isset($_POST["acao"])){
	if($_POST["acao"]=="listarcidade"){
		$cidade = new Cidade();
		$cidadeDao = new CidadeDAO($conexao);
		if(isset($_POST["idestado"])){
				$cidade->setIdEstado($_POST["idestado"]);
		}        
		$query = $cidadeDao->consultarCidade($cidade);
		while($resultset = $cidadeDao->listarCidade($query))
		{
			$data[] = [
			"idcidade" => $resultset["idcidade"],
			"cidade" => $resultset["cidade"]    ];
		}
	   echo json_encode($data);
	}

	if($_POST["acao"]=="gravar"){
		$cidade = new Cidade();
		$cidadeDao = new CidadeDAO($conexao);
		$cidade->setIdPais($_POST["idpais"]);
		$cidade->setIdEstado($_POST["idestado"]);
		$cidade->setIdCidade($_POST["idcidade"]);
		$cidade->setCidade($_POST["cidade"]);
		if($cidade->getIdCidade()>0){
			$cidadeDao->atualizarCidade($cidade);	
		}else{
			$cidadeDao->inserirCidade($cidade);
		}	
		header("Location:cidadelista.php");	
	}

	if($_POST["acao"]=="excluir"){
		$cidade = new Cidade();
		$cidadeDao = new CidadeDAO($conexao);
		$cidade->setIdCidade($_POST["idcidade"]);
		$cidadeDao->deletarCidade($cidade);
		header("Location:cidadelista.php");
	}
}

$conexao->fecharConexao();
?>