<?php
include("seguranca.php");

class CentroDeCusto {
	
	private $idCentroDeCusto;
	private $centroDeCusto;
	private $endereco;
	private $numero;
	private $bairro;
	private $cep;	
	private $email;
	private $telefone;
	
	function setIdCentroDeCusto($idCentroDeCusto){
		$this->idCentroDeCusto = $idCentroDeCusto;
	}
	
	function getIdCentroDeCusto(){
		return $this->idCentroDeCusto;
	}
	
	function setCentroDeCusto($centroDeCusto){
		$this->centroDeCusto = $centroDeCusto;
	}
	
	function getCentroDeCusto(){
		return $this->centroDeCusto;
	}
	
	function setEndereco($endereco){
		$this->endereco = $endereco;
	}
	
	function getEndereco(){
		return $this->endereco;
	}
	
	function setNumero($numero){
		$this->numero = $numero;
	}
	
	function getNumero(){
		return $this->numero;
	}

	function setBairro($bairro){
		$this->bairro = $bairro;
	}
	
	function getBairro(){
		return $this->bairro;
	}
	
	function setCep($cep){
		$this->cep = $cep;
	}
	
	function getCep(){
		return $this->cep;
	}
	
	function setEmail($email){
		$this->email = $email;
	}
	
	function getEmail(){
		return $this->email;
	}

	function setTelefone($telefone){
		$this->telefone = $telefone;
	}
	
	function getTelefone(){
		return $this->telefone;
	}

}
?>