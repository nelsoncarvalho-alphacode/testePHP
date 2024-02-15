<?php

class Pais {
	
	private $idPais;
	private $pais;

	function setIdPais($idPais){
		$this->idPais = $idPais;
	}
	
	function getIdPais(){
		return $this->idPais;
	}
	
	function setPais($pais){
		$this->pais = $pais;
	}
	
	function getPais(){
		return $this->pais;
	}
	
}
?>