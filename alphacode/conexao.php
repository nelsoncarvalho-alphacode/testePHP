<?php

 class Conexao {
	 
	 private $host;
	 private $porta;
	 private $banco;
	 private $usuario;
	 private $senha;
     private $tipobanco;
     private $conexao;	 
	 
	 function __construct(){
		 $this->tipobanco = "mysql";
		 if($this->tipobanco=="postgres"){
			$this->host = "localhost";
			$this->porta = "5432";
			$this->banco = "teste";
			$this->usuario = "teste";
			$this->senha = "teste";
		 }
		 if($this->tipobanco=="mysql"){
			$this->host = "localhost";
			$this->porta = "5432";
			$this->banco = "alphacode";
			$this->usuario = "root";
			$this->senha = "";
		 }
	 }
 
	 function abrirConexao(){
		if($this->tipobanco=="postgres"){
			$strconexao  = " host=".$this->host;
			$strconexao .= " port=".$this->porta;
			$strconexao .= " dbname=".$this->banco;
			$strconexao .= " user=".$this->usuario;
			$strconexao .= " password=".$this->senha;
			$this->conexao = pg_connect($strconexao);
		    return $this->conexao; 	
		}
		if($this->tipobanco=="mysql"){
			$this->conexao = mysqli_connect($this->host,$this->usuario,$this->senha,$this->banco) ;
	        return $this->conexao;
		}		
	 }
    
	 function fecharConexao(){
		 if($this->tipobanco=="postgres"){
		   pg_close($this->conexao);
		 }
		 if($this->tipobanco=="mysql"){
		   mysqli_close($this->conexao);
     	 }
	 }
	 
	 function query($sql){
  	    if($this->tipobanco=="postgres"){
			return pg_query($this->conexao,$sql);
		}
		if($this->tipobanco=="mysql"){
			return mysqli_query($this->conexao,$sql);
		}
	 }

	 function totalRegistros($query){
		if($this->tipobanco=="postgres"){
			return pg_num_rows($query);
		}
		if($this->tipobanco=="mysql"){
			return mysqli_num_rows($query);
		}
	 }
	 
	 function listarQuery($query){			
        if($this->tipobanco=="postgres"){
			return pg_fetch_array($query);			
		}
		if($this->tipobanco=="mysql"){
			return mysqli_fetch_array($query);
		}	
	}
 }  
?>
