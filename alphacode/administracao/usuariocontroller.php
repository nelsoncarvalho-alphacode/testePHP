<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("usuario.php");
include("usuariodao.php");
include("funcoes.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(isset($_POST["acao"])){	
	

	if($_POST["acao"]=="listarusuario"){
		$validarForm = 0;
		$usuario = new Usuario();
		$usuarioDao = new UsuarioDAO($conexao);
		if($_POST["idusuario"]>0){
			$usuario->setIdUsuario($_POST["idusuario"]);
		}
		$usuario->setLogin($_POST["login"]);
		$query = $usuarioDao->consultarLogin($usuario);
		if($usuarioDao->getTotalRegistros($query)>0){
			if($validarForm==0){
			  $validarForm = 1;
			}
		}
		
		$usuario = new Usuario();
		$usuarioDao = new UsuarioDAO($conexao);
		if($_POST["idusuario"]>0){
			$usuario->setIdUsuario($_POST["idusuario"]);
		}
		
		
		$usuario->setCpf($_POST["cpf"]);
		
		if($_POST["cpf"]!=""){
			$query = $usuarioDao->consultarLogin($usuario);
			if($usuarioDao->getTotalRegistros($query)>0){
				if($validarForm==0){
				  $validarForm = 2;
				}		
			}
		}
		
		$usuario = new Usuario();
		$usuarioDao = new UsuarioDAO($conexao);
		if($_POST["idusuario"]>0){
			$usuario->setIdUsuario($_POST["idusuario"]);
		}
		
		$usuario->setCnpj($_POST["cnpj"]);
		
		if($_POST["cnpj"]!=""){
			$query = $usuarioDao->consultarLogin($usuario);
			
			if($usuarioDao->getTotalRegistros($query)>0){
				if($validarForm==0){
				  $validarForm = 3;
				}
			}
		}
		
		if($validarForm){
			echo $validarForm;
		}else{
			echo 0;
		}
		
	}
	

	if($_POST["acao"]=="gravar"){
		$usuario = new Usuario();
		$usuarioDao = new UsuarioDAO($conexao);
		$usuario->setIdUsuario($_POST["idusuario"]);
		$usuario->setNome($_POST["nome"]);
		$usuario->setLogin($_POST["login"]);
		$usuario->setSenha($_POST["senha"]);
		$usuario->setCpf($_POST["cpf"]);
		$usuario->setCnpj($_POST["cnpj"]);
		$usuario->setTelefone($_POST["telefone"]);
		$usuario->setDataNascimento(dataamd($_POST["datanascimento"]));
		$usuario->setIdNivelAcesso($_POST["idnivelacesso"]);
		$usuario->setIdCentroDeCusto($_POST["idcentrodecusto"]);
		
		if(!isset($_POST["candidatoschecked"])){
			$candidatos = 0;	
		}else{
			$candidatos = $_POST["candidatoschecked"];
		}	
		$usuario->setCandidatos($candidatos);
		
		if(!isset($_POST["vagaschecked"])){
			$vagas = 0;	
		}else{
			$vagas = $_POST["vagaschecked"];
		}	
		$usuario->setVagas($vagas);
		
		if(!isset($_POST["tipodevagachecked"])){
			$tipodevaga = 0;	
		}else{
			$tipodevaga = $_POST["tipodevagachecked"];
		}	
		$usuario->setTipodeVaga($tipodevaga);
				
		if(!isset($_POST["centrochecked"])){
			$centro = 0;	
		}else{
			$centro = $_POST["centrochecked"];
		}		
		$usuario->setCentro($centro);

		if(!isset($_POST["usuarioschecked"])){
			$usuarios = 0;	
		}else{
			$usuarios = $_POST["usuarioschecked"];
		}	
		$usuario->setUsuarios($usuarios);


		if(!isset($_POST["alterarsenhachecked"])){
			$alterarsenha = 0;	
		}else{
			$alterarsenha = $_POST["alterarsenhachecked"];
		}	
		$usuario->setAlterarSenha($alterarsenha);

		
        if(!isset($_POST["nivelacessochecked"])){
			$nivelacesso = 0;	
		}else{
			$nivelacesso = $_POST["nivelacessochecked"];
		}	
		$usuario->setNivelAcesso($nivelacesso);

		if(!isset($_POST["painelchecked"])){
			$painel = 0;	
		}else{
			$painel = $_POST["painelchecked"];
		}	
		$usuario->setPainel($painel);
		
		if(!isset($_POST["relatoriousuarioschecked"])){
			$relatoriousuarios = 0;	
		}else{
			$relatoriousuarios = $_POST["relatoriousuarioschecked"];
		}	
		$usuario->setRelatorioUsuarios($relatoriousuarios);

		if($usuario->getIdUsuario()>0){
			$filepath ="fotosusuarios/".$usuario->getIdUsuario()."/";
			if (!file_exists($filepath)) {
				umask(0);
				mkdir($filepath, 0777, true);
			}
			$path=$filepath.$_FILES['arquivo']['name'];
			move_uploaded_file($_FILES['arquivo']['tmp_name'],$path);
			$usuarioDao->atualizarUsuario($usuario);	
		}else{
			$usuarioDao->inserirUsuario($usuario);
		}	
		header("Location:usuariolista.php");	
	}

	if($_POST["acao"]=="excluir"){
		$usuario = new Usuario();
		$usuarioDao = new UsuarioDAO($conexao);
		$usuario->setIdUsuario($_POST["idusuario"]);
		$usuarioDao->deletarUsuario($usuario);
		$filepath ="fotosusuarios/".$_POST['idusuario']."/";
		$arquivo = $filepath.$_POST['imagem'];
		if(isset($arquivo) && file_exists($arquivo)){ 
		  deletarDiretorio($filepath);
		}
		if($_POST["idusuario"]==$_SESSION['idusuario_session']){
			header("Location:index.php");
		}else{	
		  	header("Location:usuariolista.php");
		}	
	}

	if($_POST["acao"]=="downloadimagem"){
		$filepath ="fotosusuarios/".$_POST['idusuario']."/";
		$arquivo = $filepath.$_POST['imagem'];
		if(isset($arquivo) && file_exists($arquivo)){ 
			switch(strtolower(substr(strrchr(basename($arquivo),"."),1))){ 
				case "pdf": $tipo="application/pdf"; break;
				case "exe": $tipo="application/octet-stream"; break;
				case "zip": $tipo="application/zip"; break;
				case "doc": $tipo="application/msword"; break;
				case "xls": $tipo="application/vnd.ms-excel"; break;
				case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
				case "gif": $tipo="image/gif"; break;
				case "png": $tipo="image/png"; break;
				case "jpg": $tipo="image/jpg"; break;
				case "mp3": $tipo="audio/mpeg"; break;
				case "php": 
				case "htm": 
				case "html": 
			}
			header("Content-Type: ".$tipo); 
			header("Content-Length: ".filesize($arquivo)); 
			header("Content-Disposition: attachment; filename=".basename($arquivo)); 
			readfile($arquivo); 
			exit; 
		}
	}

	if($_POST["acao"]=="excluirimagem"){
		$filepath ="fotosusuarios/".$_POST['idusuario']."/";
		unlink($filepath.$_POST['imagem']);
		header("Location:usuariolista.php");
	}
}
$conexao->fecharConexao();
?>
