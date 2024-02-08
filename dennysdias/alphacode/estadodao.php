<?php
include("seguranca.php");

class EstadoDAO {

    private $conexao;
    private $totalRegistros;
	
    function __construct($conexao){
		$this->conexao = $conexao;
    }

    function consultarEstado($estado){
		$sql  = " select e.*, p.pais from estado e ";
        $sql .= " inner join pais p on   ";
        $sql .= " e.idpais = p.idpais    ";
        $sql .= " where 1=1              ";
	    if($estado->getIdEstado()>0){
			$sql .= " and e.idestado = ".$estado->getIdEstado()." ";
		}
        if($estado->getIdPais()>0){
			$sql .= " and e.idpais = ".$estado->getIdPais()." ";
		}
		if($estado->getEstado()!=""){
			$sql .= " and e.estado like '%".$estado->getEstado()."%' ";
		}        
        $sql .= " order by e.estado ";		
        return $this->conexao->query($sql);			
	}
	
	function consultarEstadoSigla($estado){
		$sql  = " select * from estado where 1=1 ";
	    if($estado->getIdEstado()>0){
			$sql .= " and idestado <> ".$estado->getIdEstado()." ";
		}
		if($estado->getSigla()!=""){
			$sql .= " and sigla = '".$estado->getSigla()."' ";
		}
		return $this->conexao->query($sql);			
	}
	
	function listarEstado($query){
		return $this->conexao->listarQuery($query);
	}
	
	function getTotalRegistros($query){
		return $this->conexao->totalRegistros($query);
	}
	
	function inserirEstado($estado){
		$sql  = " insert into estado   ";
		$sql .= " (                    ";
		$sql .= "  sigla               ";
		$sql .= "  ,estado             ";		
		$sql .= "  ,idpais             ";		
		$sql .= " )                    ";
		$sql .= " values               ";
		$sql .= " (                    ";
		$sql .= "   '".$estado->getSigla()."' ";
		$sql .= "   ,'".$estado->getEstado()."' ";
        $sql .= "   ,'".$estado->getIdPais()."' ";
		$sql .= " ) ";
		$this->conexao->query($sql);
	}

    function atualizarEstado($estado){
		$sql  = " update estado set ";
		$sql .= " sigla =    '".$estado->getSigla()."'  ";
	    $sql .= " ,estado =    '".$estado->getEstado()."'  ";
        $sql .= " ,idpais =    '".$estado->getIdPais()."'  ";
		$sql .= " where idestado = ".$estado->getIdEstado()." ";
		$this->conexao->query($sql);
	}
	
	function deletarEstado($estado){
		$sql  = " delete from estado ";
	    $sql .= " where idestado = ".$estado->getIdEstado()." ";
		$this->conexao->query($sql);
	}
	
}
?>