<?php
include("seguranca.php");

class NivelAcessoDAO {

    private $conexao;
    private $totalRegistros;
	
    function __construct($conexao){
		$this->conexao = $conexao;
    }

    function consultarNivelAcesso($nivelAcesso){
		$sql  = " select * from nivelacesso where 1=1 ";
		if($nivelAcesso->getIdNivelAcesso()>0){
			$sql .= " and idnivelacesso = ".$nivelAcesso->getIdNivelAcesso()." ";
		}
		if($nivelAcesso->getNivelAcesso()!=""){
			$sql .= " and nivelacesso like '%".$nivelAcesso->getNivelAcesso()."%' ";
		}        
        $sql .= " order by nivelacesso ";
		return $this->conexao->query($sql);			
    }
	
	function listarNivelAcesso($query){
		return $this->conexao->listarQuery($query);
	}
	
	function getTotalRegistros($query){
		return $this->conexao->totalRegistros($query);
	}
	
	function inserirNivelAcesso($nivelAcesso){
		$sql  = " insert into nivelacesso       ";
		$sql .= " (                         ";
		$sql .= "  nivelacesso                  ";		
		$sql .= " )                         ";
		$sql .= " values                    ";
		$sql .= " (                          ";
		$sql .= " '".$nivelAcesso->getNivelAcesso()."' ";		
		$sql .= " )                      ";
		$this->conexao->query($sql);
	}

    function atualizarNivelAcesso($nivelAcesso){
		$sql  = " update nivelacesso set ";
		$sql .= " nivelacesso =    '".$nivelAcesso->getNivelAcesso()."'  ";
		$sql .= " where idnivelacesso = ".$nivelAcesso->getIdNivelAcesso()." ";
		$this->conexao->query($sql);
	}
	
	function deletarNivelAcesso($nivelAcesso){
		$sql  = " delete from nivelacesso ";
	    $sql .= " where idnivelacesso = ".$nivelAcesso->getIdNivelAcesso()." ";
		$this->conexao->query($sql);
	}
	
}
?>