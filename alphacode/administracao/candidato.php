<?php
include("seguranca.php");

class Candidato {
	
	private $idCandidato;
	private $nome;
	private $endereco;
	private $numero;
	private $bairro;
	private $cep;	
	private $idPais;
	private $idEstado;
	private $idCidade;
	private $email;
	private $rg;
	private $cpf;
	private $cnpj;
	private $telefone;
	private $celular;
	private $obs;
	
	function setIdCandidato($idCandidato){
		$this->idCandidato = $idCandidato;
	}
	
	function getIdCandidato(){
		return $this->idCandidato;
	}
	
	function setNome($nome){
		$this->nome = $nome;
	}
	
	function getNome(){
		return $this->nome;
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

	function setIdCidade($idCidade){
		$this->idCidade = $idCidade;
	}
	
	function getIdCidade(){
		return $this->idCidade;
	}
	
	function setEmail($email){
		$this->email = $email;
	}
	
	function getEmail(){
		return $this->email;
	}
	
	function setRg($rg){
		$this->rg = $rg;
	}
	
	function getRg(){
		return $this->rg;
	}
	
	function setCpf($cpf){
		$this->cpf = $cpf;
	}
	
	function getCpf(){
		return $this->cpf;
	}
	
	function setCnpj($cnpj){
		$this->cnpj = $cnpj;
	}
	
	function getCnpj(){
		return $this->cnpj;
	}
	
	function setTelefone($telefone){
		$this->telefone = $telefone;
	}
	
	function getTelefone(){
		return $this->telefone;
	}
	
	function setCelular($celular){
		$this->celular = $celular;
	}
	
	function getCelular(){
		return $this->celular;
	}
	
	function setObs($obs){
		$this->obs = $obs;
	}
	
	function getObs(){
		return $this->obs;
	}
	
}
?>