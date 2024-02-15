<?php
include("seguranca.php");

class VagaDAO {

    private $conexao;
    private $totalRegistros;
	
    function __construct($conexao){
		$this->conexao = $conexao;
    }
	
    function consultarVaga($vaga){
		$sql  = " select * from vagas v ";
		$sql  .= " inner join tipovaga t on ";
		$sql  .= " v.idtipovaga = t.idtipovaga ";
		$sql  .= " where 1=1 ";
	    
		if($vaga->getIdVaga()>0){
			$sql .= " and v.idvaga = ".$vaga->getIdVaga()." ";
		}
		if($vaga->getDescricao()!=""){
			$sql .= " and v.descricao like '%".$vaga->getDescricao()."%' ";
		}        
        $sql .= " order by v.idvaga ";	
        return $this->conexao->query($sql);			
	}
	
	function listarVaga($query){
		return $this->conexao->listarQuery($query);
	}
	
	function getTotalRegistros($query){
		return $this->conexao->totalRegistros($query);
	}
	
	function inserirVaga($vaga){
		$sql  = " insert into vagas     ";
		$sql .= " (                     ";
		$sql .= "  descricao            ";
        $sql .= "  ,idtipovaga          ";		
		$sql .= "  ,ativa               ";		
		$sql .= " )                     ";
		$sql .= " values                ";
		$sql .= " (                     ";
		$sql .= "   '".$vaga->getDescricao()."' ";
		$sql .= "  , '".$vaga->getIdTipoVaga()."' ";
		$sql .= "  , '".$vaga->getAtiva()."' ";
		$sql .= " ) ";
		$this->conexao->query($sql);
	}

    function atualizarVaga($vaga){
		$sql  = " update vagas set ";
		$sql .= " descricao =    '".$vaga->getDescricao()."'  ";
	    $sql .= " ,idtipovaga =    '".$vaga->getIdTipoVaga()."'  ";
		$sql .= " ,ativa =    '".$vaga->getAtiva()."'  ";
		$sql .= " where idvaga = ".$vaga->getIdVaga()." ";
		$this->conexao->query($sql);
	}
	
	function deletarVaga($vaga){
		$sql  = " delete from vagas ";
	    $sql .= " where idvaga = ".$vaga->getIdVaga()." ";
		$this->conexao->query($sql);
	}
	
}
?>