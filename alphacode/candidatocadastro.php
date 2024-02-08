<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("candidato.php");
include("candidatodao.php");
include("pais.php");
include("paisdao.php");
include("estado.php");
include("estadodao.php");
include("cidade.php");
include("cidadedao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(!empty($_POST["idcandidato"])){
	$candidato = new Candidato();
	$candidatoDao = new CandidatoDAO($conexao);
	$candidato->setIdCandidato($_POST["idcandidato"]);
	$query = $candidatoDao->consultarCandidato($candidato);
	$resultset = $candidatoDao->listarCandidato($query);

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
	
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/funcoes.js"></script>
    <script src="js/menu.js"></script>
 
	<link href="css/padding.css" rel="stylesheet">
    <link href="css/scroll.css" rel="stylesheet">
	<link href="css/navbar.css" rel="stylesheet">
	<link href="css/sticky-footer-navbar.css" rel="stylesheet">
	<script>
	 $(document).ready(function() {
		$('#cpf').mask('000.000.000-00', {reverse: true});
		$('#cnpj').mask('00.000.000/0000-00', {reverse: true});
		$('#cep').mask('00000-000');
		$('#telefone').mask('(00) 00000-0000');
		$('#celular').mask('(00) 0000-0000');
		$('#msgvalidarrg').hide();
		$('#msgvalidarcpf').hide();
		$('#msgvalidarcnpj').hide();
		$('#msgvalidardigitocpf').hide();
		$('#msgvalidardigitocnpj').hide();
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
		});	
		
		$('#nome').keydown(function(event){
		   if(event.keyCode == 13){
			$('#endereco').focus();
		   }
		});
		
		$('#endereco').keydown(function(event){
		  if(event.keyCode == 13){
			$('#numero').focus();
		  }
		});
		
		$('#numero').keydown(function(event){
		  if(event.keyCode == 13){
			$('#bairro').focus();
		  }
		});
		
		$('#bairro').keydown(function(event){
		  if(event.keyCode == 13){
			$('#cep').focus();
		  }
		});
		
		$('#cep').keydown(function(event){
		  if(event.keyCode == 13){
			$('#idpais').focus();
		  }
		});
		
		$('#idpais').keydown(function(event){
		  if(event.keyCode == 13){
			$('#idestado').focus();
		  }
		}); 
		
		$('#idestado').keydown(function(event){
		  if(event.keyCode == 13){
			$('#idcidade').focus();
		  }
		});
		
		$('#idcidade').keydown(function(event){
		  if(event.keyCode == 13){
			$('#email').focus();
		  }
		});
		
		$('#email').keydown(function(event){
		  if(event.keyCode == 13){
			$('#rg').focus();
		  }
		});
		
		$('#rg').keydown(function(event){
		  if(event.keyCode == 13){
			$('#cpf').focus();
		  }
		});
		
		$('#cpf').keydown(function(event){
		  if(event.keyCode == 13){
			$('#cnpj').focus();
		  }
		});
		
		$('#cnpj').keydown(function(event){
		  if(event.keyCode == 13){
			$('#telefone').focus();
		  }
		});
		
		$('#telefone').keydown(function(event){
		  if(event.keyCode == 13){
			$('#celular').focus();
		  }
		});
  
        $('#celular').keydown(function(event){
		  if(event.keyCode == 13){			  
			$('#obs').focus();
		  }
		});
		 
		$('#obs').keydown(function(event){
		  if(event.keyCode == 13){			  
			$("#gravar").trigger("click");
		  }
		});
		
		$("#voltar").click(function() {
		   formCandidato.action = "candidatolista.php";
		   formCandidato.submit();
		});
		 
	   //combo
       $("#idpais").change(function(){
           var idpais = $(this).val();
		   $("#idestado").empty();
		   $("#idestado").append("<option selected value=''>Selecione um estado</option>");
		   $("#idcidade").empty();
		   $("#idcidade").append("<option selected value=''>Selecione uma cidade</option>");
		   $.ajax({
                url: 'estadocontroller.php',
                type: 'post',
                data: {acao:"listarestado",idpais:idpais},
                dataType: 'json',
                success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++){
					    var idestado = response[i]['idestado'];
						var sigla = response[i]['sigla'];
						var estado = response[i]['estado'];
						$("#idestado").append("<option value='"+idestado+"'>"+sigla+"-"+estado+"</option>");
                    }
				}
            });
       });	 
		
	   //combo
       $("#idestado").change(function(){
            var idestado = $(this).val();
		    $("#idcidade").empty();
		    $("#idcidade").append("<option selected value=''>Selecione uma cidade</option>");
		    $.ajax({
                url: 'cidadecontroller.php',
                type: 'post',
                data: {acao:"listarcidade",idestado:idestado},
                dataType: 'json',
                success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++){
                        var idcidade = response[i]['idcidade'];
						var cidade = response[i]['cidade'];
						$("#idcidade").append("<option value='"+idcidade+"'>"+cidade+"</option>");
                    }
                }
            });
        });
		
		$("#formCandidato").submit(function(){
			$('#msgvalidarrg').hide();
			$('#msgvalidarcpf').hide();
			$('#msgvalidarcnpj').hide();
			$('#msgvalidardigitocpf').hide();
			$('#msgvalidardigitocnpj').hide();
			if($('#cpf').val()!=''){
				if (!validarCPF($('#cpf').val())){
					$('#msgvalidardigitocpf').show();
					$('#cpf').focus();
					return false;
				}
			}
			
			if($('#cnpj').val()!=''){
				if (!validarCNPJ($('#cnpj').val())){
					$('#msgvalidardigitocnpj').show();
					$('#cnpj').focus();
					return false;
				}
			}
			
			if($('#rg').val()!=""){
				$.ajax({
                    url: 'candidatocontroller.php',
                    type: 'post',
					data: {
						acao: "listarcandidatodocumentos",
						idcandidato: $('#idcandidato').val(),
						rg: $('#rg').val()
					},
                    success:function(result){
						if(result==1){
							$('#msgvalidarrg').show();
							$('#rg').focus();
                        }else{
							formCandidato.acao.value = "gravar";
							formCandidato.action = "candidatocontroller.php";
							formCandidato.submit();
						}
                    }
				});
				return false;
			}
			
			if($('#cpf').val()!=""){
				$.ajax({
                    url: 'candidatocontroller.php',
                    type: 'post',
					data: {
						acao: "listarcandidatodocumentos",
						idcandidato: $('#idcandidato').val(),
						cpf: $('#cpf').val()
					},
                    success:function(result){
						if(result==1){
							$('#msgvalidarcpf').show();
							$('#cpf').focus();
                        }else{
							formCandidato.acao.value = "gravar";
							formCandidato.action = "candidatocontroller.php";
							formCandidato.submit();
						}
                    }
				});
				return false;
			}
			
			if($('#cnpj').val()!=""){
				$.ajax({
                    url: 'candidatocontroller.php',
                    type: 'post',
					data: {
						acao: "listarcandidatodocumentos",
						idcandidato: $('#idcandidato').val(),
						cnpj: $('#cnpj').val()
					},
                    success:function(result){
						if(result==1){
						  $('#msgvalidarcnpj').show();
						  $('#cnpj').focus();
                        }else{
							formCandidato.acao.value = "gravar";
							formCandidato.action = "candidatocontroller.php";
							formCandidato.submit();
						}
                    }
				});
				return false;
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
			<form id="formCandidato" name="formCandidato" method="post" action="candidatocontroller.php">
				<input type="hidden" id="acao" name="acao" value="gravar">
				<input type="hidden" id="idcandidato" name="idcandidato" value="<?php echo isset($resultset["idcandidato"])? $resultset["idcandidato"]:"";?>" >
		        <div class="card">
					<h5 class="card-header">Cadastro de candidato:</h5>
					<div class="card-body">
						<div class="form-group">			
						    <label for="nome"><font color="red">*</font>Nome:</label>
							<input type="text" id="nome" name="nome" class="form-control" value="<?php echo isset($resultset["nome"])? $resultset["nome"]:"";?>" required autofocus>
						</div>  
						<div class="form-group">
							<label for="endereco">Endereço:</label>
							<input type="text" id="endereco" name="endereco" class="form-control" value="<?php echo isset($resultset["endereco"])? $resultset["endereco"]:"";?>">
						</div>
						<div class="form-group row">
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="numero">Nº:</label>
								<input type="text" id="numero" name="numero" class="form-control" value="<?php echo isset($resultset["numero"])? $resultset["numero"]:"";?>">
						    </div>
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="bairro">Bairro:</label>
								<input type="text" id="bairro" name="bairro" class="form-control" value="<?php echo isset($resultset["bairro"])? $resultset["bairro"]:"";?>">
							</div>
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="cep">Cep:</label>
								<input type="text" id="cep" name="cep" class="form-control" value="<?php echo isset($resultset["cep"])? $resultset["cep"]:"";?>">
						    </div>
						</div>
						<div class="form-group">
							<label for="idpais"><font color="red">*</font>País:</label>
							<?php 
								$pais = new Pais();
								$paisDao = new PaisDAO($conexao);
								$query = $paisDao->consultarPais($pais);
							?>
							<select id="idpais" name="idpais" class="form-control" required autofocus>
								<option selected value="">Selecione um país</option>
								<?php
									while($resultsetpais = $paisDao->listarPais($query))
									{
										$selected = "";
										if(isset($resultset["idpais"])){
											if($resultsetpais["idpais"]==$resultset["idpais"]){
												$selected = "selected";
											}													   
										} 
								?>									                  
								<option <?php echo $selected; ?> value="<?php echo $resultsetpais["idpais"];?>"><?php echo $resultsetpais["pais"];?></option>
								<?php
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="idestado"><font color="red">*</font>Estado:</label>
							<?php 
								$estado = new Estado();
								$estadoDao = new EstadoDAO($conexao);
								if(isset($resultset["idpais"])){
									$estado->setIdPais($resultset["idpais"]);
								}
								$query = $estadoDao->consultarEstado($estado);
							?>
							<select id="idestado" name="idestado" class="form-control" required>
								<option selected value="">Selecione um estado</option>
								<?php
									if(isset($_POST["idpais"]) or isset($resultset["idestado"])){
										while($resultsetestado = $estadoDao->listarEstado($query))
										{
											$selected = "";
											if(isset($resultset["idestado"])){
												if($resultsetestado["idestado"]==$resultset["idestado"]){
													$selected = "selected";
												}													   
											} 
								?>									                  
								<option <?php echo $selected; ?> value="<?php echo $resultsetestado["idestado"];?>"><?php echo $resultsetestado["estado"];?></option>
								<?php
										}
									}	
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="idcidade"><font color="red">*</font>Cidade:</label>
							<?php 
								$cidade = new Cidade();
								$cidadeDao = new CidadeDAO($conexao);
								if(isset($resultset["idestado"])){
									$cidade->setIdEstado($resultset["idestado"]);
								}
								$query = $cidadeDao->consultarCidade($cidade);
							?>
							<select id="idcidade" name="idcidade" class="form-control" required>
								<option selected value="">Selecione uma cidade</option>
								<?php
									if(isset($_POST["idestado"]) or isset($resultset["idcidade"])){
										while($resultsetcidade = $cidadeDao->listarCidade($query))
										{
											$selected = "";
											if(isset($resultset["idcidade"])){
												if($resultsetcidade["idcidade"]==$resultset["idcidade"]){
													$selected = "selected";
												}													   
											} 
								?>									                  
								<option <?php echo $selected; ?> value="<?php echo $resultsetcidade["idcidade"];?>"><?php echo $resultsetcidade["cidade"];?></option>
								<?php
										}
									}	
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" id="email" name="email" class="form-control" value="<?php echo isset($resultset["email"])? $resultset["email"]:"";?>">
						</div>
						<div class="form-group row">
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="rg">Rg:</label>
								<input type="text" id="rg" name="rg" class="form-control" value="<?php echo isset($resultset["rg"])? $resultset["rg"]:"";?>">
							</div>
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="cpf">Cpf:</label>
								<input type="text" id="cpf" name="cpf" class="form-control" value="<?php echo isset($resultset["cpf"])? $resultset["cpf"]:"";?>">
						    </div>
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="cnpj">Cnpj:</label>
								<input type="text" id="cnpj" name="cnpj" class="form-control" value="<?php echo isset($resultset["cnpj"])? $resultset["cnpj"]:"";?>">
						    </div>
						</div>
						<div id="msgvalidardigitocpf" class="alert alert-primary" role="alert">
							Cpf inválido!
						</div>
						<div id="msgvalidardigitocnpj" class="alert alert-primary" role="alert">
							Cnpj inválido!
						</div>
						<div id="msgvalidarrg" class="alert alert-primary" role="alert">
							Já existe um candidato cadastrado com este rg!
						</div>
						<div id="msgvalidarcpf" class="alert alert-primary" role="alert">
							Já existe um candidato cadastrado com este cpf!
						</div>
						<div id="msgvalidarcnpj" class="alert alert-primary" role="alert">
							Já existe um candidato cadastrado com este cnpj!
						</div>												
						<div class="form-group row">
						    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="telefone">Telefone:</label>
								<input type="tel" id="telefone" name="telefone" class="form-control" value="<?php echo isset($resultset["telefone"])? $resultset["telefone"]:"";?>">
							</div>
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="celular">Celular:</label>
								<input type="tel" id="celular" name="celular" class="form-control" value="<?php echo isset($resultset["celular"])? $resultset["celular"]:"";?>">
							</div>								
						</div>
						<div class="form-group">
								<label for="obs">Observações:</label>
								<textarea id="obs" name="obs" class="form-control" id="obs" rows="3"><?php echo isset($resultset["obs"])? $resultset["obs"]:"";?></textarea>
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