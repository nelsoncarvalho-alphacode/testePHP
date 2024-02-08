<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("usuario.php");
include("usuariodao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

$usuario = new Usuario();
$usuarioDao = new UsuarioDAO($conexao);

$msg="";
if(isset($_POST["acao"])){
	$usuario->setIdUsuario($_POST["idusuario"]);
	if(($_POST["senha"]==$_SESSION['senha_session'])){
	   if($_POST["novasenha"]==$_POST["confirmesenha"]){
	       $usuario->setSenha($_POST["novasenha"]);
	       $usuarioDao->alterarSenha($usuario);
		   $_SESSION['senha_session']=$_POST["novasenha"];
		   $msg=2;		  
	   }else{
		   $msg=3;
	   }		
	}else{
		$msg=1;
	}	
}

if(isset($_SESSION['idusuario_session'])){
	$usuario->setIdUsuario($_SESSION['idusuario_session']);
	$query = $usuarioDao->consultarUsuario($usuario);
	$resultset = $usuarioDao->listarUsuarios($query);
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administração</title>
	
	<link href="bootstrap-4.1.3/css/bootstrap.min.css" rel="stylesheet">
	<script src="jquery/jquery-3.1.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
	<script src="bootstrap-4.1.3/js/bootstrap.min.js"></script>
	  
    <script src="js/menu.js"></script>
  		 
	<!-- Custom styles for this template -->
	<link href="css/padding.css" rel="stylesheet">
    <link href="css/scroll.css" rel="stylesheet">
	<link href="css/navbar.css" rel="stylesheet">
	<link href="css/sticky-footer-navbar.css" rel="stylesheet">
	
  </head>
  <body>
  
    <header>      
     <?php include("menu.php");?>
    </header>

    <main role="main">
	 	<div id="cadastro" class="top col">
			<form name="formUsuario" method="post" action="usuarioalterarsenha.php">
				<input type="hidden" name="acao" value="alterarsenha">
				<input type="hidden" name="idusuario" value="<?php echo isset($resultset["idusuario"])? $resultset["idusuario"]:"";?>" >
				<div class="card">
					<h5 class="card-header">Alterar Senha:</h5>
					<div class="card-body">
						<p>Preencha os campos abaixo, e clique em alterar:</p>
						<div class="form-group row">
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="senha"><font color="red">*</font>Senha Atual:</label>
								<input type="password" class="form-control" id="senha" name="senha" value="" required autofocus>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="senha"><font color="red">*</font>Nova Senha:</label>
								<input type="password" class="form-control" id="novasenha" name="novasenha" value="" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="senha"><font color="red">*</font>Confirme a Senha:</label>
								<input type="password" class="form-control" id="confirmesenha" name="confirmesenha" value="" required>
							</div>
						</div>
						<div class="form-group">
                            <button class="btn btn-outline-secondary" type="submit">Alterar</button>
                        </div>
						<p>
						<?php 
						    if(isset($msg)){
                           		if($msg==1){										   
						?>
								<div class="alert alert-dark" role="alert">
									A senha atual não conferem!
								</div>
							<?php 
								}
								if($msg==2){
							?>								  
								<div class="alert alert-primary" role="alert">
									Senha alterada com sucesso!
								</div>
							<?php 
								}
								if($msg==3){
							?>	  
								<div class="alert alert-dark" role="alert">
									A nova senha e confirmação não conferem!
								</div>										  
							<?php									  
								}
							} 
						?>		 
						</p>
           			</div>
                </div>
			</form>
		</div>

     <?php include("footer.php");?>
	  
    </main>

  </body>
</html>
<?php 
$conexao->fecharConexao();
?>