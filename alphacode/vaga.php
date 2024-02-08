<?php

class Vaga {
	
	private $idVaga;
	private $descricao;
	private $idTipoVaga;
	private $ativa;
	
	function setIdVaga($idVaga){
		$this->idVaga = $idVaga;
	}
	
	function getIdVaga(){
		return $this->idVaga;
	}
	
	function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	
	function getDescricao(){
		return $this->descricao;
	}
	
	function setIdTipoVaga($idTipoVaga){
		$this->idTipoVaga = $idTipoVaga;
	}
	
	function getIdTipoVaga(){
		return $this->idTipoVaga;
	}
	
	function setAtiva($ativa){
		$this->ativa = $ativa;
	}
	
	function getAtiva(){
		return $this->ativa;
	}
}
?>