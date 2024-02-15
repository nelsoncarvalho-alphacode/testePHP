<?php
include("seguranca.php");

class TipoVagaDAO {

    private $conexao;
    private $totalRegistros;
	
    function __construct($conexao){
		$this->conexao = $conexao;
    }
	
    function consultarTipoVaga($tipoVaga){
		$sql  = " select * from tipovaga where 1=1 ";
	    if($tipoVaga->getIdTipoVaga()>0){
			$sql .= " and idtipovaga = ".$tipoVaga->getIdTipoVaga()." ";
		}
		if($tipoVaga->getTipo()!=""){
			$sql .= " and tipo like '%".$tipoVaga->getTipo()."%' ";
		}        
        $sql .= " order by idtipovaga ";		
		return $this->conexao->query($sql);			
	}
	
	function listarTipoVaga($query){
		return $this->conexao->listarQuery($query);
	}
	
	function getTotalRegistros($query){
		return $this->conexao->totalRegistros($query);
	}
	
	function inserirTipoVaga($tipoVaga){
		$sql  = " insert into tipovaga ";
		$sql .= " (                    ";
		$sql .= "  tipo            ";		
		$sql .= " )                    ";
		$sql .= " values               ";
		$sql .= " (                    ";
		$sql .= "   '".$tipoVaga->getTipo()."' ";
		$sql .= " ) ";
		$this->conexao->query($sql);
	}

    function atualizarTipoVaga($tipoVaga){
		$sql  = " update tipovaga set ";
		$sql .= " tipo =    '".$tipoVaga->getTipo()."'  ";
	    $sql .= " where idtipovaga = ".$tipoVaga->getIdTipoVaga()." ";
		$this->conexao->query($sql);
	}
	
	function deletarTipoVaga($tipoVaga){
		$sql  = " delete from tipovaga ";
	    $sql .= " where idtipovaga = ".$tipoVaga->getIdTipoVaga()." ";
		$this->conexao->query($sql);
	}
	
}
?>