<?php
include("seguranca.php");

class Cidade {
	
	private $idCidade;
	private $cidade;
	private $idPais;
	private $idEstado;
	
	function setIdCidade($idCidade){
		$this->idCidade = $idCidade;
	}
	
	function getIdCidade(){
		return $this->idCidade;
	}
	
	function setCidade($cidade){
		$this->cidade = $cidade;
	}
	
	function getCidade(){
		return $this->cidade;
	}
	
	function setIdPais($idPais){
		$this->idPais = $idPais;
	}
	
	function getIdPais(){
		return $this->idPais;
	}
	
	function setIdEstado($idEstado){
		$this->idEstado = $idEstado;
	}
	
	function getIdEstado(){
		return $this->idEstado;
	}
	
}
?>