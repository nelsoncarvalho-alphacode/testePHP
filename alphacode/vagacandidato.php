<?php

class VagaCandidato {
	
	private $idVagaCandidato;
	private $idVaga;
	private $idCandidato;
	
	function setIdVagaCandidato($idVagaCandidato){
		$this->idVagaCandidato = $idVagaCandidato;
	}
	
	function getIdVagaCandidato(){
		return $this->idVagaCandidato;
	}
	
	function setIdVaga($idVaga){
		$this->idVaga = $idVaga;
	}
	
	function getIdVaga(){
		return $this->idVaga;
	}
	
	function setIdCandidato($idCandidato){
		$this->idCandidato = $idCandidato;
	}
	
	function getIdCandidato(){
		return $this->idCandidato;
	}
}
?>