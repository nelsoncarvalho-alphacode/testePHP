<?php
include("seguranca.php");

class CentroDeCustoDAO {

    private $conexao;
    private $totalRegistros;
	
	function __construct($conexao){
		$this->conexao = $conexao;
    }

    function consultarCentroDeCusto($centroDeCusto){
		$sql  = " select c.* from centrodecusto c ";
		$sql  .= " where 1=1 ";
	    if($centroDeCusto->getIdCentroDeCusto()>0){
			$sql .= " and idcentrodecusto = ".$centroDeCusto->getIdCentroDeCusto()." ";
		}
		if($centroDeCusto->getCentroDeCusto()!=""){
			$sql .= " and centrodecusto like '%".$centroDeCusto->getCentroDeCusto()."%' ";
		}
        $sql .= " order by centrodecusto ";	
       	return $this->conexao->query($sql);			
	}
	
	function listarCentroDeCusto($query){
		return $this->conexao->listarQuery($query);
	}
	
	function getTotalRegistros($query){
		return $this->conexao->totalRegistros($query);
	}
	
	function inserirCentroDeCusto($centroDeCusto){
		$sql  = " insert into centrodecusto  ";
		$sql .= " (                    ";
		$sql .= "  centrodecusto       ";
		if($centroDeCusto->getEndereco()!=""){
			$sql .= " ,endereco            ";
		}
		if($centroDeCusto->getNumero()!=""){
			$sql .= " ,numero        ";
		}
		if($centroDeCusto->getBairro()!=""){
			$sql .= " ,bairro        ";
		}		
		if($centroDeCusto->getCep()!=""){
			$sql .= " ,cep        ";
		}
    	$sql .= " ,email            ";
		if($centroDeCusto->getTelefone()!=""){
			$sql .= " ,telefone            ";
		}
		$sql .= " )                    ";
		$sql .= " values               ";
		$sql .= " (                    ";
		$sql .= "   '".$centroDeCusto->getCentroDeCusto()."' ";		
		if($centroDeCusto->getEndereco()!=""){
		   $sql .= " , '".$centroDeCusto->getEndereco()."' ";
		}
		if($centroDeCusto->getNumero()!=""){
		   $sql .= " , '".$centroDeCusto->getNumero()."' ";
		}
		if($centroDeCusto->getBairro()!=""){
		   $sql .= " , '".$centroDeCusto->getBairro()."' ";
		}		
		if($centroDeCusto->getCep()!=""){
		   $sql .= " , '".$centroDeCusto->getCep()."' ";
		}
    	$sql .= " , '".$centroDeCusto->getEmail()."' ";
		if($centroDeCusto->getTelefone()!=""){
		   $sql .= " , '".$centroDeCusto->getTelefone()."' ";
		}
		$sql .= " ) ";
      	$this->conexao->query($sql);
	}

    function atualizarCentroDeCusto($centroDeCusto){
		$sql  = " update centrodecusto set ";
	    $sql .= " centrodecusto =    '".$centroDeCusto->getCentroDeCusto()."'  ";
		$sql .= " ,endereco = '".$centroDeCusto->getEndereco()."'  ";
		$sql .= " ,numero = '".$centroDeCusto->getNumero()."'  ";
		$sql .= " ,bairro = '".$centroDeCusto->getBairro()."'  ";
		$sql .= " ,cep = '".$centroDeCusto->getCep()."'  ";
		$sql .= " ,email = '".$centroDeCusto->getEmail()."'  ";
		$sql .= " ,telefone = '".$centroDeCusto->getTelefone()."'  ";
		$sql .= " where idcentrodecusto = ".$centroDeCusto->getIdCentroDeCusto()." ";
		$this->conexao->query($sql);
	}
	
	
	function deletarCentroDeCusto($centroDeCusto){
		$sql  = " delete from centrodecusto ";
	    $sql .= " where idcentrodecusto = ".$centroDeCusto->getIdCentroDeCusto()." ";
		$this->conexao->query($sql);
	}
	
}
?>