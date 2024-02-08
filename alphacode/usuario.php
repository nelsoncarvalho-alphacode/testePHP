<?php
include("segurancausuario.php");

class Usuario {
	
	private $idUsuario;
	private $nome;
	private $login;
	private $senha;
	private $cpf;
	private $cnpj;
	private $telefone;
	private $datanascimento;
	private $idNivelAcesso;
	private $idCentroDeCusto;
	
	//permissões
	private $centro;
	private $usuarios;
	private $alterarSenha;
	private $nivelacesso;
	private $painel;
	private $relatoriousuarios;
	
	function setIdUsuario($idUsuario){
		$this->idUsuario = $idUsuario;
	}
	
	function getIdUsuario(){
		return $this->idUsuario;
	}
	
	function setNome($nome){
		$this->nome = $nome;
	}
	
	function getNome(){
		return $this->nome;
	}
		
	function setLogin($login){
		$this->login = $login;
	}
	
	function getLogin(){
		return $this->login;
	}

	function setSenha($senha){
		$this->senha = $senha;
	}
	
	function getSenha(){
		return $this->senha;
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
	
	function setDataNascimento($datanascimento){
		$this->datanascimento = $datanascimento;
	}
	
	function getDataNascimento(){
		return $this->datanascimento;
	}
	
	function setIdNivelAcesso($idNivelAcesso){
		$this->idNivelAcesso = $idNivelAcesso;
	}
	
	function getIdNivelAcesso(){
		return $this->idNivelAcesso;
	}

	function setIdCentroDeCusto($idCentroDeCusto){
		$this->idCentroDeCusto = $idCentroDeCusto;
	}
	
	function getIdCentroDeCusto(){
		return $this->idCentroDeCusto;
	}
	
	function setCentro($centro){
		$this->centro = $centro;
	}
	
	function getCentro(){
		return $this->centro;
	}
		
	function setUsuarios($usuarios){
		$this->usuarios = $usuarios;
	}
	
	function getUsuarios(){
		return $this->usuarios;
	}

	function setAlterarSenha($alterarSenha){
		$this->alterarSenha = $alterarSenha;
	}
	
	function getAlterarSenha(){
		return $this->alterarSenha;
	}
	
	function setSolucoes($solucoes){
		$this->solucoes = $solucoes;
	}
	
	function getSolucoes(){
		return $this->solucoes;
	}
	
	function setNivelAcesso($nivelacesso){
		$this->nivelacesso = $nivelacesso;
	}
	
	function getNivelAcesso(){
		return $this->nivelacesso;
	}
	
	function setPainel($painel){
		$this->painel = $painel;
	}
	
	function getPainel(){
		return $this->painel;
	}
	
	function setRelatorioUsuarios($relatoriousuarios){
		$this->relatoriousuarios = $relatoriousuarios;
	}
	
	function getRelatorioUsuarios(){
		return $this->relatoriousuarios;
	}
}
?>