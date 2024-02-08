<?php

include("administracao/conexao.php");
include("vaga.php");
include("vagadao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

$vaga = new Vaga();
$vagaDao = new VagaDAO($conexao);
$vaga->setAtiva(1);
$query = $vagaDao->consultarVaga($vaga);

?>
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
		function candidatar(idvaga) {
		  formVaga.idvaga.value = idvaga;
		  formVaga.acao.value = "candidatar";
          formVaga.action = "candidatocadastro.php";
          formVaga.submit();
		}
	</script>
    
  </head>

  <body class="text-center">
      <div id="cadastro" class="top col">
			<form id="formVaga" name="formVaga" method="post" action="candidatocadastro.php">
				<input type="hidden" id="acao" name="acao" value="gravar">
				<input type="hidden" id="idvaga" name="idvaga" value="<?php echo isset($_POST["idvaga"])? $POST["idvaga"]:"";?>" >
                <center>
				<img class="img-fluid" width="300" height="200" src="administracao/img/logo.png" alt="Alphacode">
	            </center>
				</br></br>
               <?php  
				while($resultset = $vagaDao->listarVaga($query))
				{
				?>
               	    <div class="card">
						<h5 class="card-header">Vaga código: <?php echo $resultset["idvaga"];?></h5>
						<div class="card-body">
						    <div class="form-group">			
								<label for="codigo">Descrição:</label>
								<?php echo $resultset["descricao"];?>
								<?php echo $resultset["tipo"];?>
                    	    </div>
							
						   <div class="form-group">
						        <button type="button" class="btn btn-outline-secondary" style="width: 120px" onclick="candidatar(<?php echo $resultset["idvaga"];?>)">Candidatar-se</button>
						   </div>							
						</div>
					</div>
					</br></br>					
                <?php
                 }
				?>	
			</form>		
		</div>
  </body>
</html>
<?php 
 $conexao->fecharConexao();
?>