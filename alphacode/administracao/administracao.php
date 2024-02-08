<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("funcoes.php");

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set("America/Fortaleza");

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
  	<script src="jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="popper/popper.min.js"></script>
	  <script src="bootstrap-4.1.3/js/bootstrap.min.js"></script>
	
	  <script src="grafico/js/Chart.bundle.js"></script>
	  <script src="grafico/js/utils.js"></script>
    <script src="js/menu.js"></script>

	  <link href="css/mobile.css" rel="stylesheet">
    <link href="css/padding.css" rel="stylesheet">
    <link href="css/carousel.css" rel="stylesheet">
	  <link href="css/scroll.css" rel="stylesheet">
	
    <link href="css/navbar.css" rel="stylesheet">
	  <link href="css/sticky-footer-navbar.css" rel="stylesheet">

  </head>
  <body>
  
    <header>
      
     <?php include("menu.php");?>
    </header>

	
    <main role="main">
    	
	  <div id="cadastro" class="topinicial col">
		
		<div class="card">
		  <div class="card-header textomobile">
			Painel:
		  </div>
		  <div class="card-body textomobile">
          </div>   
        	  
			
		</div>
		
	  </div>	
		
	</div>			
 
     <?php include("footerdefault.php");?>
	  
    </main>

  </body>
</html>
