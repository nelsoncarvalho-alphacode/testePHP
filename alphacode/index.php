<?php
session_start();
session_destroy();
session_start();

$_SESSION["permissaousuario_session"]="ok";

include("conexao.php");
include("usuario.php");
include("usuariodao.php");
    

$conexao = new Conexao();
$conexao->abrirConexao();
$msg ="";

if(isset($_POST["acao"])){
	$login  = $_POST["login"];
	$senha    = $_POST["senha"];
	$usuario = new Usuario();
    $usuarioDao = new UsuarioDAO($conexao);
    $usuario->setLogin($login);
	$usuario->setSenha($senha);
    $query = $usuarioDao->consultarUsuario($usuario);
	$resultset = $usuarioDao->listarUsuarios($query);
    $totalregistro = $usuarioDao->getTotalRegistros($query);
	if ($totalregistro > 0){
		$_SESSION["idusuario_session"] = $resultset['idusuario'];
		$_SESSION["nome_session"] = $resultset['nome'];
		$_SESSION["login_session"] = $resultset['login'];
		$_SESSION["senha_session"] = $resultset['senha'];
		$_SESSION["idcentrodecusto_session"] = $resultset['idcentrodecusto'];
		$_SESSION["centrodecusto_session"] = $resultset['centrodecusto'];
		$_SESSION["centro_session"] = $resultset['centro'];
		$_SESSION["usuarios_session"] = $resultset['usuarios'];
		$_SESSION["alterarsenha_session"] = $resultset['alterarsenha'];
		$_SESSION["solucoes_session"] = $resultset['solucoes'];
		$_SESSION["nivelacesso_session"] = $resultset['nivelacesso'];
		$_SESSION["painel_session"] = $resultset['painel'];
		$_SESSION["relatoriousuarios_session"] = $resultset['relatoriousuarios'];
		header('Location: administracao.php');
	}else{
		$msg ="Usuário invalido!";
	}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-4.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="post" action="index.php" >
	<input type="hidden" name="acao" value="enviar">
	  <img class="img-fluid card-img-top" src="img/logo.png" alt="SoftBuilder">
	  <h1 class="h3 mb-3 font-weight-normal">Login:</h1>
	  <p class="mt-5 mb-3 text-muted">Informe usuario e senha e click em entrar:</p>
      <label for="login" class="sr-only">Usuário:</label>
      <input type="text" id="login" name="login" class="form-control" placeholder="Usuário" required autofocus>
      <label for="senha" class="sr-only">Senha:</label>
      <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
      <p>
		 <?php if(!empty($msg)){ ?>
		   <div class="alert alert-primary" role="alert">
             <?php echo $msg;?>
           </div>
		 <?php }?>		 
	  </p>
	  <p class="mt-5 mb-3 text-muted">Copyright &copy;</p>
	 </form>
  </body>
</html>
<?php 
$conexao->fecharConexao();
?>