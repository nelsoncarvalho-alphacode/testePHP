<?php
include("seguranca.php");

class CidadeDAO {

    private $conexao;
    private $totalRegistros;
	
    function __construct($conexao){
		$this->conexao = $conexao;
    }

    function consultarCidade($cidade){
		$sql  = " select c.*,e.estado,p.pais from cidade c ";
		$sql  .= " inner join estado e on ";
		$sql  .= " c.idestado = e.idestado ";
        $sql  .= " inner join pais p on ";
		$sql  .= " e.idpais = p.idpais ";
		$sql  .= " where 1=1 ";
	    if($cidade->getIdCidade()>0){
			$sql .= " and idcidade = ".$cidade->getIdCidade()." ";
		}
		if($cidade->getCidade()!=""){
			$sql .= " and cidade like '%".$cidade->getCidade()."%' ";
		}
		if($cidade->getIdEstado()>0){
			$sql .= " and c.idestado = ".$cidade->getIdEstado()." ";
		}        
        $sql .= " order by cidade ";		
		return $this->conexao->query($sql);			
	}
	
	function listarCidade($query){
		return $this->conexao->listarQuery($query);
	}
	
	function getTotalRegistros($query){
		return $this->conexao->totalRegistros($query);
	}
	
	function inserirCidade($cidade){
		$sql  = " insert into cidade   ";
		$sql .= " (                    ";
		$sql .= "  cidade              ";
		$sql .= "  ,idpais             ";
        $sql .= "  ,idestado           ";		
		$sql .= " )                    ";
		$sql .= " values               ";
		$sql .= " (                    ";
		$sql .= "   '".$cidade->getCidade()."' ";
		$sql .= "  ,".$cidade->getIdPais()." ";
        $sql .= "  ,".$cidade->getIdEstado()." ";		
		$sql .= " ) ";
		$this->conexao->query($sql);
	}

    function atualizarCidade($cidade){
		$sql  = " update cidade set ";
	    $sql .= " cidade =    '".$cidade->getCidade()."'  ";
		$sql .= "  ,idpais = ".$cidade->getIdPais()." ";
        $sql .= "  ,idestado = ".$cidade->getIdEstado()." ";
		$sql .= " where idcidade = ".$cidade->getIdCidade()." ";
		$this->conexao->query($sql);
	}
	
	function deletarCidade($cidade){
		$sql  = " delete from cidade ";
	    $sql .= " where idcidade = ".$cidade->getIdCidade()." ";
		$this->conexao->query($sql);
	}
	
}
?>