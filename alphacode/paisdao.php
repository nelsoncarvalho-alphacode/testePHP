<?php

class PaisDAO {

    private $conexao;
    private $totalRegistros;
	
    function __construct($conexao){
		$this->conexao = $conexao;
    }

    function consultarPais($pais){
		$sql  = " select * from pais where 1=1 ";
	    if($pais->getIdPais()>0){
			$sql .= " and idpais = ".$pais->getIdPais()." ";
		}
		if($pais->getPais()!=""){
			$sql .= " and pais like '%".$pais->getPais()."%' ";
		}        
        $sql .= " order by pais ";		
		return $this->conexao->query($sql);			
	}
	
	function listarPais($query){
		return $this->conexao->listarQuery($query);
	}
	
	function getTotalRegistros($query){
		return $this->conexao->totalRegistros($query);
	}
	
	function inserirPais($pais){
		$sql  = " insert into pais       ";
		$sql .= " (                      ";
		$sql .= "  pais                  ";		
		$sql .= " )                      ";
		$sql .= " values                 ";
		$sql .= " (                      ";
		$sql .= " '".$pais->getPais()."' ";		
		$sql .= " )                      ";
		$this->conexao->query($sql);
	}

    function atualizarPais($pais){
		$sql  = " update pais set ";
		$sql .= " pais =    '".$pais->getPais()."'  ";
		$sql .= " where idpais = ".$pais->getIdPais()." ";
		$this->conexao->query($sql);
	}
	
	function deletarPais($pais){
		$sql  = " delete from pais ";
	    $sql .= " where idpais = ".$pais->getIdPais()." ";
		$this->conexao->query($sql);
	}
	
}
?>