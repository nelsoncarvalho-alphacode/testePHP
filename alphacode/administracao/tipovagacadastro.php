<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("tipovaga.php");
include("tipovagadao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(!empty($_POST["idtipovaga"])){
	$tipoVaga = new TipoVaga();
	$tipoVagaDao = new TipoVagaDAO($conexao);
	$tipoVaga->setIdTipoVaga($_POST["idtipovaga"]);
	$query = $tipoVagaDao->consultarTipoVaga($tipoVaga);
	$resultset = $tipoVagaDao->listarTipoVaga($query);
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
        
        $('#tipo').keydown(function(event){
		  if(event.keyCode == 13){
			$( "#gravar" ).trigger( "click" );
		  }
		});
		
		$("#voltar").click(function() {
		   formTipoVaga.action = "tipovagalista.php";
		   formTipoVaga.submit();
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
			<form id="formTipoVaga" name="formTipoVaga" method="post" action="tipovagacontroller.php">
				<input type="hidden" id="acao" name="acao" value="gravar">
				<input type="hidden" id="idtipovaga" name="idtipovaga" value="<?php echo isset($resultset["idtipovaga"])? $resultset["idtipovaga"]:"";?>" >
		         	<div class="card">
						<h5 class="card-header">Cadastro de tipo de vaga:</h5>
						<div class="card-body">
						    <div class="form-group">			
								<label for="tipo"><font color="red">*</font>Tipo de vaga:</label>
								<input type="text" id="tipo" name="tipo" class="form-control" value="<?php echo isset($resultset["tipo"])? $resultset["tipo"]:"";?>" required autofocus>
							</div>																 
							<div class="form-group">
								<button class="btn btn-outline-secondary" type="submit" id="gravar" name="gravar" >Gravar</button>
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