<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("vaga.php");
include("vagadao.php");
include("tipovaga.php");
include("tipovagadao.php");
include("vagacandidato.php");
include("vagacandidatodao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(!empty($_POST["idvaga"])){
	$vaga = new Vaga();
	$vagaDao = new VagaDAO($conexao);
	$vaga->setIdVaga($_POST["idvaga"]);
	$query = $vagaDao->consultarVaga($vaga);
	$resultset = $vagaDao->listarVaga($query);
	 
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
        
		$('#descricao').keydown(function(event){
		   if(event.keyCode == 13){
			 $('#idtipovaga').focus();
		   }
		});
		
		$('#idtipovaga').keydown(function(event){
		   if(event.keyCode == 13){
			$('#ativa').focus();
		   }
		});
		
        $('input:radio[name=ativa]').keydown(function(e){
			var code = e.keyCode || e.which;
			if(code==13){
				$("#gravar").trigger("click");
			}
		});
		
		
		$("#voltar").click(function() {
		   formVaga.action = "vagalista.php";
		   formVaga.submit();
		});
		
  	 });
	 function excluircandidatura(idvagacandidato) {
		  formVaga.idvagacandidato.value = idvagacandidato;
		  formVaga.acao.value = "excluircandidatura";
          formVaga.action = "vagacontroller.php";
          formVaga.submit();
	}
	</script>	
  </head>
  <body>
  
    <header>      
     <?php include("menu.php");?>
    </header>
	
    <main role="main">

		<div id="cadastro" class="top col">
			<form id="formVaga" name="formVaga" method="post" action="vagacontroller.php">
				<input type="hidden" id="acao" name="acao" value="gravar">
				<input type="hidden" id="idvaga" name="idvaga" value="<?php echo isset($resultset["idvaga"])? $resultset["idvaga"]:"";?>" >
		     	<input type="hidden" id="idvagacandidato" name="idvagacandidato" value="" >
		     		
				<div class="bd-example bd-example-tabs">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="vaga-tab" data-toggle="tab" href="#vaga" role="tab" aria-controls="vaga" aria-selected="true">Vaga</a>
						</li>
						<?php
							$vagaCandidato = new VagaCandidato();
							$vagaCandidatoDao = new VagaCandidatoDAO($conexao);
							$vagaCandidato->setIdVaga($_POST["idvaga"]);
							$query = $vagaCandidatoDao->consultarVagaCandidato($vagaCandidato);
							
							$totalregistros = $vagaCandidatoDao->getTotalRegistros($query);
							
	                        if($totalregistros>0){
						?>
						<li class="nav-item">
							<a class="nav-link" id="candidatos-tab" data-toggle="tab" href="#candidatos" role="tab" aria-controls="candidatos" aria-selected="false">Candidatos</a>
						</li>
                        <?php 
						   }
						?>    						
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="vaga" role="tabpanel" aria-labelledby="vaga-tab">
							</br>
							<div class="card">
								<h5 class="card-header">Cadastro de vaga:</h5>
								<div class="card-body">
									<div class="form-group">			
										<label for="codigo"><font color="red">*</font>Código:</label>
										<?php echo isset($resultset["idvaga"])? $resultset["idvaga"]:"";?>
									</div>
									<div class="form-group">			
										<label for="descricao"><font color="red">*</font>Descrição:</label>
										<textarea id="descricao" name="descricao" class="form-control" id="descricao" rows="5"><?php echo isset($resultset["descricao"])? $resultset["descricao"]:"";?></textarea>
									</div>
									<div class="form-group">
										<label for="idtipovaga"><font color="red">*</font>Tipo de vaga:</label>
										<?php 
											$tipoVaga = new TipoVaga();
											$tipoVagaDao = new TipoVagaDAO($conexao);
											$query = $tipoVagaDao->consultarTipoVaga($tipoVaga);
										?>
										<select id="idtipovaga" name="idtipovaga" class="form-control" required autofocus>
											<option selected value="">Selecione um tipo de vaga</option>
											<?php
											
												while($resultsettipovaga = $tipoVagaDao->listarTipoVaga($query))
												{
													$selected = "";
													if(isset($resultset["idtipovaga"])){
														if($resultsettipovaga["idtipovaga"]==$resultset["idtipovaga"]){
															$selected = "selected";
														}													   
													} 
												?>									                  
											<option <?php echo $selected; ?> value="<?php echo $resultsettipovaga["idtipovaga"];?>"><?php echo $resultsettipovaga["tipo"];?></option>
											<?php
												}
											?>
										</select>
									</div>
									
									<?php 
										$checkedsim ="checked";
										$checkednao ="";
										if(isset($resultset["ativa"])){
											if($resultset["ativa"]==1){
												$checkedsim ="checked";
											}else{
												$checkednao ="checked";	  
											}
										} 	  
									?>
									<p><font color="red">*</font>Ativa</p>
									<div class="form-check">
										<input class="form-check-input" type="radio" id="ativa" name="ativa"  value="1" <?php echo $checkedsim; ?>>
										<label class="form-check-label" for="ativa">
											Sim
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" id="ativa" name="ativa"  value="0" <?php echo $checkednao; ?>>
										<label class="form-check-label" for="ativa">
											Não
										</label>
									</div>
								   </br>  
								   <div class="form-group">
										<button class="btn btn-outline-secondary" type="submit" id="gravar" name="gravar" >Gravar</button>
										<button class="btn btn-outline-secondary" type="button" id="voltar" name="voltar" >Voltar</button>  
									</div>							
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="candidatos" role="tabpanel" aria-labelledby="candidatos-tab">
						    
							<table class="table table-striped">
							  <thead>
								<tr>
								  <th scope="col">código</th>
								  <th scope="col">Nome</th>
								  <th scope="col">Excluir</th>								  
								</tr>
							  </thead>
							  <tbody>
								<?php
								 $vagaCandidatoLista = new VagaCandidato();
								 $vagaCandidatoListaDao = new VagaCandidatoDAO($conexao);
								 $vagaCandidatoLista->setIdVaga($_POST["idvaga"]);
								 $query = $vagaCandidatoListaDao->consultarVagaCandidato($vagaCandidatoLista);
															
								 while($resultsetvagacandidato = $vagaCandidatoListaDao->listarVagaCandidato($query))
								 {   
								?>
								<tr>
								  <th scope="row">
								   <?php 
								     echo $resultsetvagacandidato["idvagacandidato"];
								   ?>
								  </th>
								  <td>
								   <?php 
								     echo $resultsetvagacandidato["nome"];
								   ?>
								   </td>
								  <td><button type="button" class="btn btn-outline-secondary" style="width: 120px" onclick="excluircandidatura(<?php echo $resultsetvagacandidato["idvagacandidato"];?>)">Excluir</button></td>								 
								</tr>
								<?php 
								}
								?>
							  </tbody>
							</table>
							
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