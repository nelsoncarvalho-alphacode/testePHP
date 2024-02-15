<?php

class Estado {
	
	private $idEstado;
	private $sigla;
	private $estado;
	private $idPais;
	
	function setIdEstado($idEstado){
		$this->idEstado = $idEstado;
	}
	
	function getIdEstado(){
		return $this->idEstado;
	}
	
	function setSigla($sigla){
		$this->sigla = $sigla;
	}
	
	function getSigla(){
		return $this->sigla;
	}
	
	function setEstado($estado){
		$this->estado = $estado;
	}
	
	function getEstado(){
		return $this->estado;
	}
	
	function setIdPais($idPais){
		$this->idPais = $idPais;
	}
	
	function getIdPais(){
		return $this->idPais;
	}
	
}
?>