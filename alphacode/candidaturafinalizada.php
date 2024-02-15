<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vagas</title>

    <link href="administracao/bootstrap-4.1.3/css/bootstrap.min.css" rel="stylesheet">
	<script src="administracao/jquery/jquery-3.1.1.min.js"></script>
    <script src="administracao/popper/popper.min.js"></script>
	<script src="administracao/bootstrap-4.1.3/js/bootstrap.min.js"></script>
	
	<script src="administracao/js/jquery.mask.min.js"></script>
	<script src="administracao/js/funcoes.js"></script>
    <script src="administracao/js/menu.js"></script>
 
	<link href="administracao/css/padding.css" rel="stylesheet">
    <link href="administracao/css/scroll.css" rel="stylesheet">
	<link href="administracao/css/navbar.css" rel="stylesheet">
	<link href="administracao/css/sticky-footer-navbar.css" rel="stylesheet">
	
	<script>
		function voltar() {
		  formVaga.action = "index.php";
          formVaga.submit();
		}
	</script>
    
  </head>

  <body class="text-center">
      <div id="cadastro" class="top col">
			<form id="formVaga" name="formVaga" method="post" action="index.php">
				<center>
				<img class="img-fluid" width="300" height="200" src="administracao/img/logo.png" alt="Aphacode">
	            </center>
				</br></br>
               	    <div class="card">
						<h5 class="card-header">Candidatura finalizada!</h5>
						<div class="card-body">
						    <div class="form-group">			
								<label for="codigo">Boa sorte!</label>
			      	        </div>
						   <div class="form-group">
						        <button type="button" class="btn btn-outline-secondary" style="width: 120px" onclick="voltar()">Voltar</button>
						   </div>							
						</div>
					</div>
					</br></br>					
               	
			</form>		
		</div>
  </body>
</html>
