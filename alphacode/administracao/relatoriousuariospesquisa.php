<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("usuario.php");
include("usuariodao.php");


$conexao = new Conexao();
$conexao->abrirConexao();

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
	
    <link rel="stylesheet" href="jquery/jqueryui/css/jquery-ui.css">
    <script src="jquery/jqueryui/js/jquery-ui.js"></script>
	  <script src="js/jquery.mask.min.js"></script>
	  <script src="js/moment.js"></script>
	
	  <link href="gijgo-combined-1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="gijgo-combined-1.9.10/js/gijgo.min.js" type="text/javascript"></script>
    <script src="gijgo-combined-1.9.10/js/messages/messages.pt-br.js" type="text/javascript"></script>

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
       
       
        $('#usuario').keydown(function(event){
          if(event.keyCode == 13){
            $("#imprimir").trigger( "click" );
          }
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
			<form id="formRelatorio" name="formRelatorio" method="post" action="relatoriousuarios.php">
				<div class="card">
					<h5 class="card-header">Relatório de Usuários:</h5>
				    <div class="card-body">
            			<div class="form-group">
							<label for="usuario">Usuário:</label>
							<input type="text" id="usuario" name="usuario" placeholder="Usuário" class="form-control" value="">
						</div>
				        <div class="form-group">
						    <button class="btn btn-outline-secondary" type="submit" id="imprimir" name="imprimir">Imprimir</button>
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