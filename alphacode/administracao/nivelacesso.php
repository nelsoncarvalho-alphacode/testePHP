<?php
include("seguranca.php");

class NivelAcesso {
	
	private $idNivelAcesso;
	private $nivelAcesso;

	function setIdNivelAcesso($idNivelAcesso){
		$this->idNivelAcesso = $idNivelAcesso;
	}
	
	function getIdNivelAcesso(){
		return $this->idNivelAcesso;
	}
	
	function setNivelAcesso($nivelAcesso){
		$this->nivelAcesso = $nivelAcesso;
	}
	
	function getNivelAcesso(){
		return $this->nivelAcesso;
	}
	
}
?>