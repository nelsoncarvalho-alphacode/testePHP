<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("nivelacesso.php");
include("nivelacessodao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(!empty($_POST["idnivelacesso"])){
	$nivelAcesso = new NivelAcesso();
	$nivelAcessoDao = new NivelAcessoDAO($conexao);
	$nivelAcesso->setIdNivelAcesso($_POST["idnivelacesso"]);
	$query = $nivelAcessoDao->consultarNivelAcesso($nivelAcesso);
	$resultset = $nivelAcessoDao->listarNivelAcesso($query);

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
	<script>
	 $(document).ready(function() {
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
		});

		$('#sigla').keydown(function(event){
		   if(event.keyCode == 13){
			$('#nivelAcesso').focus();
		   }
		});		
		
        $('#nivelAcesso').keydown(function(event){
		  if(event.keyCode == 13){
			$("#gravar").trigger("click");
		  }
		});
		
		$("#voltar").click(function() {
		   formNivelAcesso.action = "nivelacessolista.php";
		   formNivelAcesso.submit();
		});
		
		$("#formNivelAcesso").submit(function(){
    		formNivelAcesso.acao.value = "gravar";
			formNivelAcesso.action = "nivelacessocontroller.php";
			formNivelAcesso.submit();
	    });
	 });
	</script>	
  </head>
  <body>
  
    <header>      
     <?php include("menu.php");?>
    </header>
	
    <main role="main">
	
		<div id="cadastro" class="top col">	
			<form id="formNivelAcesso" name="formNivelAcesso" method="post" action="nivelAcessocontroller.php">
				<input type="hidden" id="acao"  name="acao" value="gravar">
				<input type="hidden" id="idnivelacesso" name="idnivelacesso" value="<?php echo isset($resultset["idnivelacesso"])? $resultset["idnivelacesso"]:"";?>" >
		        <div class="card">
					<h5 class="card-header">Cadastro de Nível de Acesso:</h5>
					<div class="card-body">
						<div class="form-group">			
							<label for="nivelAcesso"><font color="red">*</font>Nível de Acesso:</label>
							<input type="text" id="nivelacesso" name="nivelacesso" class="form-control" value="<?php echo isset($resultset["nivelacesso"])? $resultset["nivelacesso"]:"";?>" required autofocus>
						</div>																 
						<div class="form-group">
						    <button class="btn btn-outline-secondary" type="submit" id="gravar" name="gravar">Gravar</button>
							<button class="btn btn-outline-secondary" type="button" id="voltar" name="voltar" >Voltar</button>									
						</div>
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