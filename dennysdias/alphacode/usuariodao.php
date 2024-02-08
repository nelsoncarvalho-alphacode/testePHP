<?php
include("segurancausuario.php");

class UsuarioDAO {

    private $conexao;
    private $totalRegistros;
	
	function __construct($conexao){
		$this->conexao = $conexao;
    }

    function consultarUsuario($usuario){
		$sql   = " select u.*,c.centrodecusto, n.nivelacesso as niveldeacesso from usuario u       "; 
		$sql  .= " inner join centrodecusto c on ";
		$sql  .= "  u.idcentrodecusto = c.idcentrodecusto ";
		$sql  .= " inner join nivelacesso n on ";
		$sql  .= "  u.idnivelacesso = n.idnivelacesso ";
		
		$sql  .= " where 1=1 ";
	    if($usuario->getIdUsuario()>0){
			$sql .= " and idusuario = ".$usuario->getIdUsuario()." ";
		}
		if($usuario->getNome()!=""){
			$sql .= " and nome like '%".$usuario->getNome()."%' ";
		}
        if($usuario->getLogin()!=""){
			$sql .= " and login = '".$usuario->getLogin()."' ";
		}
		if($usuario->getSenha()!=""){
			$sql .= " and senha = '".$usuario->getSenha()."' ";
		}
		if($usuario->getIdCentroDeCusto()>0){
			$sql .= " and u.idcentrodecusto = ".$usuario->getIdCentroDeCusto()." ";
		}
        $sql .= " order by nome ";		
		return $this->conexao->query($sql);			
	}
	
	function consultarLogin($usuario){
		$sql   = " select u.*,c.centrodecusto from usuario u       "; 
		$sql  .= " inner join centrodecusto c on ";
		$sql  .= "  u.idcentrodecusto = c.idcentrodecusto ";
		$sql  .= " where 1=1 ";
	    if($usuario->getIdUsuario()>0){
			$sql .= " and idusuario <> ".$usuario->getIdUsuario()." ";
		}		
        if($usuario->getLogin()!=""){
			$sql .= " and login = '".$usuario->getLogin()."' ";
		}
		if($usuario->getCpf()!=""){
			$sql .= " and cpf = '".$usuario->getCpf()."' ";
		}
		if($usuario->getCnpj()!=""){
			$sql .= " and cnpj = '".$usuario->getCnpj()."' ";
		}
		return $this->conexao->query($sql);			
	}
	
	function listarUsuarios($query){
		return $this->conexao->listarQuery($query);
	}
	
	function getTotalRegistros($query){
		return $this->conexao->totalRegistros($query);
	}
	
	function inserirUsuario($usuario){
		$sql  = " insert into usuario  ";
		$sql .= " (nome                ";
		$sql .= " ,login               ";
		$sql .= " ,senha               ";
		$sql .= " ,cpf                 ";
		$sql .= " ,cnpj                ";
		$sql .= " ,telefone            ";
		$sql .= " ,datanascimento      ";
		$sql .= " ,idnivelacesso       ";
		$sql .= " ,idcentrodecusto     ";
		$sql .= " ,centro              ";
		$sql .= " ,usuarios            ";
		$sql .= " ,alterarsenha        ";
		$sql .= " ,nivelacesso         ";
		$sql .= " ,painel              ";
		$sql .= " ,relatoriousuarios   ";
		$sql .= " )                    ";
		$sql .= " values               ";
		$sql .= " ( '".$usuario->getNome()."'           ";
		$sql .= " , '".$usuario->getLogin()."'          ";
		$sql .= " , '".$usuario->getSenha()."'          ";
		$sql .= " , '".$usuario->getCpf()."'            ";
		$sql .= " , '".$usuario->getCnpj()."'           ";
		$sql .= " , '".$usuario->getTelefone()."'       ";
		$sql .= " , '".$usuario->getDataNascimento()."' ";
		$sql .= " ,  ".$usuario->getIdNivelAcesso()." ";
		$sql .= " ,  ".$usuario->getIdCentroDeCusto()." ";
		$sql .= " , ".$usuario->getCentro()."    ";
		$sql .= " , ".$usuario->getUsuarios()." ";
		$sql .= " , ".$usuario->getAlterarSenha()."    ";
		$sql .= " , ".$usuario->getNivelAcesso()."    ";
		$sql .= " , ".$usuario->getPainel()."    ";
		$sql .= " , ".$usuario->getRelatorioUsuarios()."    ";
		$sql .= " )    ";
		$this->conexao->query($sql);
		
	}

    function atualizarUsuario($usuario){
		$sql  = " update usuario set ";
	    $sql .= " nome =    '".$usuario->getNome()."'  ";
		$sql .= " ,login = '".$usuario->getLogin()."'  ";
		$sql .= " ,senha = '".$usuario->getSenha()."'  ";
		$sql .= " ,cpf = '".$usuario->getCpf()."'  ";
		$sql .= " ,cnpj = '".$usuario->getCnpj()."'  ";
		$sql .= " ,telefone = '".$usuario->getTelefone()."'  ";
		$sql .= " ,datanascimento = '".$usuario->getDataNascimento()."'  ";
		$sql .= " ,idnivelacesso = ".$usuario->getIdNivelAcesso()."  ";
		$sql .= " ,idcentrodecusto = ".$usuario->getIdCentroDeCusto()."  ";
		$sql .= " ,centro = ".$usuario->getCentro()."  ";
		$sql .= " ,usuarios = ".$usuario->getUsuarios()."  ";
	    $sql .= " ,alterarsenha = ".$usuario->getAlterarSenha()."  ";
		$sql .= " ,nivelacesso = ".$usuario->getNivelAcesso()."  ";
		$sql .= " ,painel = ".$usuario->getPainel()."  ";
		$sql .= " ,relatoriousuarios = ".$usuario->getRelatorioUsuarios()."  ";
		$sql .= " where idusuario = ".$usuario->getIdUsuario()." ";
		$this->conexao->query($sql);
	}
	
	function alterarSenha($usuario){
		$sql  = " update usuario set ";
	 	$sql .= "  senha = '".$usuario->getSenha()."' ";
		$sql .= " where idusuario = ".$usuario->getIdUsuario()." ";
		$this->conexao->query($sql);
	}
	
	function deletarUsuario($usuario){
		$sql  = " delete from usuario ";
	    $sql .= " where idusuario = ".$usuario->getIdUsuario()." ";
		$this->conexao->query($sql);
	}
}
?>