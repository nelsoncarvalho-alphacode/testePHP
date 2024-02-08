<?php
include("seguranca.php");

class TipoVaga {
	
	private $idTipoVaga;
	private $tipo;
	
	function setIdTipoVaga($idTipoVaga){
		$this->idTipoVaga = $idTipoVaga;
	}
	
	function getIdTipoVaga(){
		return $this->idTipoVaga;
	}
	
	function setTipo($tipo){
		$this->tipo = $tipo;
	}
	
	function getTipo(){
		return $this->tipo;
	}
	
}
?>