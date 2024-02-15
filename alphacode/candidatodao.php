<?php


class CandidatoDAO {

    private $conexao;
    private $totalRegistros;
	
    function __construct($conexao){
		$this->conexao = $conexao;
    }

    function consultarCandidato($candidato){
		$sql   = " select c.*,e.sigla,e.estado,cid.cidade from candidato c ";
		$sql  .= " inner join estado e on";
		$sql  .= " c.idestado = e.idestado ";
		$sql  .= " inner join cidade cid on";
		$sql  .= " c.idcidade = cid.idcidade ";
		$sql  .= " where 1=1 ";
		
	    if($candidato->getIdCandidato()>0){
			$sql .= " and idcandidato = ".$candidato->getIdCandidato()." ";
		}
		if($candidato->getNome()!=""){
			$sql .= " and nome like '%".$candidato->getNome()."%' ";
		}
        if($candidato->getIdPais()>0){
			$sql .= " and c.idpais = ".$candidato->getIdPais()." ";
		}
		if($candidato->getIdEstado()>0){
			$sql .= " and c.idestado = ".$candidato->getIdEstado()." ";
		}
		if($candidato->getIdCidade()>0){
			$sql .= " and c.idcidade = ".$candidato->getIdCidade()." ";
		}
        if($candidato->getCpf()!=""){
			$sql .= " and cpf like '%".$candidato->getCpf()."%' ";
		}
        if($candidato->getCnpj()!=""){
			$sql .= " and cnpj like '%".$candidato->getCnpj()."%' ";
		}        
        $sql .= " order by nome ";	
       		
		return $this->conexao->query($sql);			
	}
	
	function consultarUltimoCandidato(){
		$sql   = " select max(idcandidato) as idcandidato from candidato c ";
		return $this->conexao->query($sql);			
	}
	
	function listarCandidato($query){
		return $this->conexao->listarQuery($query);
	}
	
	function getTotalRegistros($query){
		return $this->conexao->totalRegistros($query);
	}
	
	function inserirCandidato($candidato){
		$sql  = " insert into candidato  ";
		$sql .= " (                    ";
		$sql .= "  nome                ";
		if($candidato->getEndereco()!=""){
			$sql .= " ,endereco        ";
		}
		if($candidato->getNumero()!=""){
			$sql .= " ,numero        ";
		}
		if($candidato->getBairro()!=""){
			$sql .= " ,bairro        ";
		}		
		if($candidato->getCep()!=""){
			$sql .= " ,cep        ";
		}
        $sql .= " ,idpais              ";
		$sql .= " ,idestado            ";
		$sql .= " ,idcidade            ";
		if($candidato->getEmail()!=""){
			$sql .= " ,email            ";
		}
		if($candidato->getRg()!=""){
			$sql .= " ,rg            ";
		}
		if($candidato->getCpf()!=""){
			$sql .= " ,cpf            ";
		}
		if($candidato->getCnpj()!=""){
			$sql .= " ,cnpj            ";
		}
		if($candidato->getTelefone()!=""){
			$sql .= " ,telefone            ";
		}
		if($candidato->getCelular()!=""){
			$sql .= " ,celular            ";
		}
        if($candidato->getObs()!=""){
			$sql .= " ,obs            ";
		}
		$sql .= " )                    ";
		$sql .= " values               ";
		$sql .= " (                    ";
		$sql .= "   '".$candidato->getNome()."' ";		
		if($candidato->getEndereco()!=""){
		   $sql .= " , '".$candidato->getEndereco()."' ";
		}
		if($candidato->getNumero()!=""){
		   $sql .= " , '".$candidato->getNumero()."' ";
		}
		if($candidato->getBairro()!=""){
		   $sql .= " , '".$candidato->getBairro()."' ";
		}		
		if($candidato->getCep()!=""){
		   $sql .= " , '".$candidato->getCep()."' ";
		}
        $sql .= " , ".$candidato->getIdPais()." ";
		$sql .= " , ".$candidato->getIdEstado()." ";
		$sql .= " , ".$candidato->getIdCidade()." ";
		if($candidato->getEmail()!=""){
		   $sql .= " , '".$candidato->getEmail()."' ";
		}
		if($candidato->getRg()!=""){
		   $sql .= " , '".$candidato->getRg()."' ";
		}
		if($candidato->getCpf()!=""){
		   $sql .= " , '".$candidato->getCpf()."' ";
		}
		if($candidato->getCnpj()!=""){
		   $sql .= " , '".$candidato->getCnpj()."' ";
		}
		if($candidato->getTelefone()!=""){
		   $sql .= " , '".$candidato->getTelefone()."' ";
		}
		if($candidato->getCelular()!=""){
		   $sql .= " , '".$candidato->getCelular()."' ";
		}
        if($candidato->getObs()!=""){
		   $sql .= " , '".$candidato->getObs()."' ";
		}
		$sql .= " ) ";
		$this->conexao->query($sql);
	}

    function atualizarCandidato($candidato){
		$sql  = " update candidato set ";
	    $sql .= " nome =    '".$candidato->getNome()."'  ";
		$sql .= " ,endereco = '".$candidato->getEndereco()."'  ";
		$sql .= " ,numero = '".$candidato->getNumero()."'  ";
		$sql .= " ,bairro = '".$candidato->getBairro()."'  ";
		$sql .= " ,cep = '".$candidato->getCep()."'  ";
		$sql .= " ,idpais = ".$candidato->getIdPais()."  ";
		$sql .= " ,idestado = ".$candidato->getIdEstado()."  ";
		$sql .= " ,idcidade = ".$candidato->getIdCidade()."  ";
		$sql .= " ,email = '".$candidato->getEmail()."'  ";
		$sql .= " ,rg = '".$candidato->getRg()."'  ";
		$sql .= " ,cpf = '".$candidato->getCpf()."'  ";
		$sql .= " ,cnpj = '".$candidato->getCnpj()."'  ";
		$sql .= " ,telefone = '".$candidato->getTelefone()."'  ";
		$sql .= " ,celular = '".$candidato->getCelular()."'  ";
        $sql .= " ,obs = '".$candidato->getObs()."'  ";
		$sql .= " where idcandidato = ".$candidato->getIdCandidato()." ";
		
		$this->conexao->query($sql);
	}
	
	function deletarCandidato($candidato){
		$sql  = " delete from candidato ";
	    $sql .= " where idcandidato = ".$candidato->getIdCandidato()." ";
		$this->conexao->query($sql);
	}
	
}
?>
