<?php

class VagaCandidatoDAO {

    private $conexao;
    private $totalRegistros;
	
    function __construct($conexao){
		$this->conexao = $conexao;
    }
	
    function consultarVagaCandidato($vagaCandidato){
		$sql  = " select * from vagacandidato vc ";
		$sql  .= " where 1=1 ";
	    
		if($vagaCandidato->getIdVaga()>0){
			$sql .= " and vc.idvaga = ".$vagaCandidato->getIdVaga()." ";
		}
		if($vagaCandidato->getIdCandidato()>0){
			$sql .= " and vc.idcandidato = ".$vagaCandidato->getIdCandidato()." ";
		} 
		 
        $sql .= " order by vc.idvagacandidato ";	
        return $this->conexao->query($sql);			
	}
	
	function listarVagaCandidato($query){
		return $this->conexao->listarQuery($query);
	}
	
	function getTotalRegistros($query){
		return $this->conexao->totalRegistros($query);
	}
	
	function inserirVagaCandidato($vagaCandidato){
		$sql  = " insert into vagacandidato     ";
		$sql .= " (                             ";
		$sql .= "  idvaga                       ";
        $sql .= "  ,idcandidato                 ";		
		$sql .= " )                     ";
		$sql .= " values                ";
		$sql .= " (                     ";
		$sql .= "    ".$vagaCandidato->getIdVaga()." ";
		$sql .= "  , ".$vagaCandidato->getIdCandidato()." ";
		$sql .= " ) ";
		$this->conexao->query($sql);
	}

    
	
	function deletarVagaCandidato($vagaCandidato){
		$sql  = " delete from vagacandidato ";
	    $sql .= " where idvagacandidato = ".$vagaCandidato->getIdVagaCandidato()." ";
		$this->conexao->query($sql);
	}
	
}
?>