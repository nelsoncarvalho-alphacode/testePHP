<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("funcoes.php");
include("usuario.php");
include("usuariodao.php");
include("nivelacesso.php");
include("nivelacessodao.php");
include("centrodecusto.php");
include("centrodecustodao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

if(!empty($_POST["idusuario"])){
	$usuario = new Usuario();
	$usuarioDao = new UsuarioDAO($conexao);
	$usuario->setIdUsuario($_POST["idusuario"]);
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
	
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/funcoes.js"></script>
    <script src="js/menu.js"></script>
 
	<link href="css/padding.css" rel="stylesheet">
    <link href="css/scroll.css" rel="stylesheet">
	<link href="css/navbar.css" rel="stylesheet">
	<link href="css/sticky-footer-navbar.css" rel="stylesheet">
	
	<link href="gijgo-combined-1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="gijgo-combined-1.9.10/js/gijgo.min.js" type="text/javascript"></script>
    <script src="gijgo-combined-1.9.10/js/messages/messages.pt-br.js" type="text/javascript"></script>
  
	
	<script>
	 $(document).ready(function() {
		$('#cpf').mask('000.000.000-00', {reverse: true});
		$('#cnpj').mask('00.000.000/0000-00', {reverse: true});
		$('#telefone').mask('(00) 00000-0000');
		$('#msgvalidarlogin').hide();
		$('#msgvalidarcpf').hide();
		$('#msgvalidardigitocpf').hide();
		$('#msgvalidarcnpj').hide();
		$('#msgvalidardigitocnpj').hide();
			
		
        $('#datanascimento').mask("00/00/0000", {placeholder: "__/__/____"});
		$('#datanascimento').datepicker({
            locale: 'pt-br',
            uiLibrary: 'bootstrap4',
			format: 'dd/mm/yyyy',
        });

		
		$('#datanascimento').change(function() {
		  $('#datanascimento').focus();
		});
		
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
		});	
		
		$('#nome').keydown(function(event){
		   if(event.keyCode == 13){
			$('#funcionario').focus();
		   }
		});
		
		$('#funcionario').keydown(function(event){
		   if(event.keyCode == 13){
			$('#login').focus();
		   }
		});
		
		$('#login').keydown(function(event){
		  if(event.keyCode == 13){
			$('#senha').focus();
		  }
		});
		
		$('#senha').keydown(function(event){
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
			$('#datanascimento').focus();
		  }
		});
		
		$('#datanascimento').keydown(function(event){
		  if(event.keyCode == 13){
			$('#idsolucao').focus();
		  }
		});
		
		$('#idsolucao').keydown(function(event){
		  if(event.keyCode == 13){
			$('#idnivelacesso').focus();
		  }
		});
		
    	$('#idnivelacesso').keydown(function(event){
		  if(event.keyCode == 13){
			$('#idcentrodecusto').focus();
		  }
		});
	
        $('#idcentrodecusto').keydown(function(event){
		  if(event.keyCode == 13){
			$("#gravar").trigger("click");
		  }
		});

		$("#voltar").click(function() {
		   formUsuario.action = "usuariolista.php";
		   formUsuario.submit();
		});

		$("#formUsuario").submit(function(){
		
			$.ajax({
                    url: 'usuariocontroller.php',
                    type: 'post',
					data: {
						acao: "listarusuario",
						idusuario: $('#idusuario').val(),
						login: $('#login').val(),
						cpf: $('#cpf').val(),
						cnpj: $('#cnpj').val()
					},
                    success:function(result){
						if(result==1){
						   $('#msgvalidarlogin').show();
						   $('#login').focus();
                        }else if(result==2){
						   $('#msgvalidarcpf').show();
						   $('#cpf').focus();
                        }else if(result==3){
					       $('#msgvalidarcnpj').show();
						   $('#cnpj').focus();
  					    }else{
							formUsuario.acao.value = "gravar";
							formUsuario.action = "usuariocontroller.php";
							formUsuario.submit();
						}
                    }
            });
			return false;
	      });
		 
		 
		 		  
 	 });
		
	 function prepararExclusaoImagem(imagem) {
	 	formUsuario.imagem.value = imagem;
	 }
	 
	 function excluirImagem(){	
     	formUsuario.target = "_self";
		formUsuario.acao.value = "excluirimagem";
		formUsuario.action = "usuariocontroller.php";
		formUsuario.submit();
	 }
	
	 function downloadImagem(imagem){	
     	formUsuario.target = "_self";
		formUsuario.imagem.value = imagem;
		formUsuario.acao.value = "downloadimagem";
		formUsuario.action = "usuariocontroller.php";
		formUsuario.submit();
	 }
  </script>
	
  </head>
  <body>
  
    <header>      
     <?php include("menu.php");?>
    </header>
	
    <main role="main">
		<div id="cadastro" class="top col">
			<form id="formUsuario" name="formUsuario" enctype="multipart/form-data" method="post" action="usuariocontroller.php">
				<input type="hidden" id="acao" name="acao" value="gravar">
				<input type="hidden" id="imagem" name="imagem" value="">
				<input type="hidden" id="idusuario" name="idusuario" value="<?php echo isset($resultset["idusuario"])? $resultset["idusuario"]:"";?>" >
				<div class="bd-example bd-example-tabs">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="dados-tab" data-toggle="tab" href="#dados" role="tab" aria-controls="dados" aria-selected="true">Dados</a>
						</li>
						<?php 
						if(!empty($_POST["idusuario"])){
						?>
							<li class="nav-item">
								<a class="nav-link" id="foto-tab" data-toggle="tab" href="#foto" role="tab" aria-controls="foto" aria-selected="false">Foto</a>
							</li>
						<?php
						}
						?>
						<li class="nav-item">
							<a class="nav-link" id="permissoes-tab" data-toggle="tab" href="#permissoes" role="tab" aria-controls="permissoes" aria-selected="false">Permissões</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
							</br>
							<div class="card">
								<h5 class="card-header">Cadastro de usuários:</h5>
								<div class="card-body">
									<div class="form-group">			
										<label for="nome"><font color="red">*</font>Nome:</label>
										<input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($resultset["nome"])? $resultset["nome"]:"";?>" required autofocus>
									</div>
                                    <div class="form-group row">
										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
											<label for="login"><font color="red">*</font>Login:</label>
											<input type="login" class="form-control" id="login" name="login" value="<?php echo isset($resultset["login"])? $resultset["login"]:"";?>" required>
										</div>
									</div>
									<div id="msgvalidarlogin" class="alert alert-primary" role="alert">
									Usuario inválido!
									</div>
									<div class="form-group row">
										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
											<label for="senha"><font color="red">*</font>Senha:</label>
											<input type="password" class="form-control" id="senha" name="senha" value="<?php echo isset($resultset["senha"])? $resultset["senha"]:"";?>" required>
										</div>
									</div>
									<div class="form-group row">
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
									<div id="msgvalidarcpf" class="alert alert-primary" role="alert">
										Já existe um cliente cadastrado com este cpf!
									</div>
									<div id="msgvalidarcnpj" class="alert alert-primary" role="alert">
										Já existe um cliente cadastrado com este cnpj!
									</div>	
									<div class="form-group row">
										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
											<label for="telefone">Telefone:</label>
											<input type="tel" id="telefone" name="telefone" class="form-control" value="<?php echo isset($resultset["telefone"])? $resultset["telefone"]:"";?>">
										</div>
									</div>
                                    <div class="form-group row" >
										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
											<label for="datanascimento"><font color="red">*</font>Data nascimento:</label>
											<input type="text" id="datanascimento" name="datanascimento" class="form-control" value="<?php echo isset($resultset["datanascimento"])? datadma($resultset["datanascimento"]):"";?>" required autofocus>
										</div>
								    </div>
									<div class="form-group">
										<label for="idnivelacesso"><font color="red">*</font>Nível de Acesso:</label>
										<?php 
											$nivelAcesso = new NivelAcesso();
											$nivelAcessoDao = new NivelAcessoDAO($conexao);
											$querynivelacesso = $nivelAcessoDao->consultarNivelAcesso($nivelAcesso);
										?>
										<select class="form-control" id="idnivelacesso" name="idnivelacesso"  required>
											<option selected value="">Selecione um nível de acesso</option>
											<?php
												while($resultsetnivelacesso = $nivelAcessoDao->listarNivelAcesso($querynivelacesso))
												{
													$selected = "";
													if(isset($resultset["idnivelacesso"])){
														if($resultsetnivelacesso["idnivelacesso"]==$resultset["idnivelacesso"]){
														   $selected = "selected";
														}													   
													} 
											?>									                  
											<option <?php echo $selected; ?> value="<?php echo $resultsetnivelacesso["idnivelacesso"];?>"><?php echo $resultsetnivelacesso["nivelacesso"];?></option>
											<?php
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="idcentrodecusto"><font color="red">*</font>Centro de custo:</label>
										<?php 
											$centroDeCusto = new CentroDeCusto();
											$centroDeCustoDao = new CentroDeCustoDAO($conexao);
											$querycentrodecusto = $centroDeCustoDao->consultarCentroDeCusto($centroDeCusto);
										?>
										<select class="form-control" id="idcentrodecusto" name="idcentrodecusto"  required>
											<option selected value="">Selecione um centro de custo</option>
											<?php
												while($resultsetcentrodecusto = $centroDeCustoDao->listarCentroDeCusto($querycentrodecusto))
												{
													$selected = "";
													if(isset($resultset["idcentrodecusto"])){
														if($resultsetcentrodecusto["idcentrodecusto"]==$resultset["idcentrodecusto"]){
														   $selected = "selected";
														}													   
													} 
											?>									                  
											<option <?php echo $selected; ?> value="<?php echo $resultsetcentrodecusto["idcentrodecusto"];?>"><?php echo $resultsetcentrodecusto["centrodecusto"];?></option>
											<?php
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<button class="btn btn-outline-secondary" id="gravar" name="gravar" type="submit">Gravar</button>
										<button class="btn btn-outline-secondary" type="button" id="voltar" name="voltar" >Voltar</button>																	</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="foto" role="tabpanel" aria-labelledby="foto-tab">
							</br>
							<div class="form-group">
								<label for="arquivo">Anexar foto</label>
								<input type="file" class="form-control-file" id="arquivo" name="arquivo" />
								</br>
								<?php
								$pasta = "fotosusuarios/".$resultset["idusuario"]."/";
								$arquivos = glob("$pasta{*.jpg,*.png,*.gif,*.bmp}", GLOB_BRACE);
								$rest = sizeof($arquivos)%2;
								$linha = 0;
								foreach($arquivos as $img){
									$imagem  = basename($img);
									$linha++;
								?>
									<?php
									if($linha==1){
									?>		
										<div class="row">
									<?php } ?>	
											<div class="col-lg-4">
												<div class="card">
													<img class="img-fluid card-img-top" src="<?php echo $img; ?>" alt="Card image cap">
													<div class="card-body">
														<p align="center"><?php echo $imagem;?>
															</br></br>
															<button class="btn btn-outline-secondary" type="button" onclick="downloadImagem('<?php echo $imagem;?>')" >Download</button>
															<button class="btn btn-outline-secondary" type="button"  style="width: 70px" onclick="prepararExclusaoImagem('<?php echo $imagem;?>')"  data-toggle="modal" data-target="#excluir">Excluir</button>
														</p>											
													</div>
												</div>
											</div>
										<?php
										if($linha==2){
											$linha = 0;										
										?>	
										</div>
										</br>
										<?php 
										} 
	  									?>										
									<?php 
									} 
									?>
									<?php
									if($rest>0){								
									?>
										</div>
										</br>
									<?php 
									} 
									?>									
							</div>
						</div>
						<div class="tab-pane fade" id="permissoes" role="tabpanel" aria-labelledby="permissoes-tab">
							</br>
							<div class="container">
								<div class="card-deck mb-3 text-center">
									
									<div class="card mb-4 shadow-sm">
										<div class="card-header">
											<h4 class="my-0 font-weight-normal">Controle de acesso:</h4>
										</div>
										<div class="card-body" align="left">
											<ul class="list-unstyled mt-3 mb-4" align="left">
												<div class="form-check">
													<?php
														$checked ='';						  
														if(isset($resultset["candidatos"])){
															if($resultset["candidatos"]==1){ 
																$checked ='checked="checked"';
															}  
														}	 
													?>
													<input class="form-check-input" type="checkbox" <?php echo isset($checked)? $checked:""; ?> value="1" id="candidatoschecked" name="candidatoschecked">
													<label class="form-check-label" for="candidatoschecked">
														Candidatos
													</label>
												</div>
                                                <div class="form-check">
													<?php
														$checked ='';						  
														if(isset($resultset["vagas"])){
															if($resultset["vagas"]==1){ 
																$checked ='checked="checked"';
															}  
														}	 
													?>
													<input class="form-check-input" type="checkbox" <?php echo isset($checked)? $checked:""; ?> value="1" id="vagaschecked" name="vagaschecked">
													<label class="form-check-label" for="vagaschecked">
														Vagas
													</label>
												</div>
                                                <div class="form-check">
													<?php
														$checked ='';						  
														if(isset($resultset["tipodevaga"])){
															if($resultset["tipodevaga"]==1){ 
																$checked ='checked="checked"';
															}  
														}	 
													?>
													<input class="form-check-input" type="checkbox" <?php echo isset($checked)? $checked:""; ?> value="1" id="tipodevagachecked" name="tipodevagachecked">
													<label class="form-check-label" for="tipodevagachecked">
														Tipo de vagas
													</label>
												</div>												
												<div class="form-check">
													<?php
														$checked ='';						  
														if(isset($resultset["usuarios"])){
															if($resultset["usuarios"]==1){ 
																$checked ='checked="checked"';
															}  
														}	 
													?>
													<input class="form-check-input" type="checkbox" <?php echo isset($checked)? $checked:""; ?> value="1" id="usuarioschecked" name="usuarioschecked">
													<label class="form-check-label" for="usuarioschecked">
														Usuários
													</label>
												</div>
												<div class="form-check">
													<?php 
														$checked =''; 
														if(isset($resultset["alterarsenha"])){
															if($resultset["alterarsenha"]==1){ 
																$checked ='checked="checked"';
															}  
														}	 
													?>
													<input class="form-check-input" type="checkbox" <?php echo isset($checked)? $checked:""; ?> value="1" id="alterarsenhachecked" name="alterarsenhachecked">
													<label class="form-check-label" for="alterarsenhachecked">
														Alterar senha
													</label>
												</div>
												<div class="form-check">
													<?php
														$checked ='';	
														if(isset($resultset["nivelacesso"])){
															if($resultset["nivelacesso"]==1){ 
																$checked ='checked="checked"';
															}  
														}	 
													?>
													<input class="form-check-input" type="checkbox" <?php echo isset($checked)? $checked:""; ?> value="1" id="nivelacessochecked" name="nivelacessochecked">
													<label class="form-check-label" for="nivelacessochecked">
														Nível Acesso
													</label>
												</div>
												<div class="form-check">
													<?php
														$checked ='';	
														if(isset($resultset["centro"])){
															if($resultset["centro"]==1){ 
																$checked ='checked="checked"';
															}  
														}	 
													?>
													<input class="form-check-input" type="checkbox" <?php echo isset($checked)? $checked:""; ?> value="1" id="centrochecked" name="centrochecked">
													<label class="form-check-label" for="centrochecked">
														Centro de custo
													</label>
												</div>
												<div class="form-check">
													<?php
														$checked ='';	
														if(isset($resultset["relatoriousuarios"])){
															if($resultset["relatoriousuarios"]==1){ 
																$checked ='checked="checked"';
															}  
														}	 
													?>
													<input class="form-check-input" type="checkbox" <?php echo isset($checked)? $checked:""; ?> value="1" id="relatoriousuarioschecked" name="relatoriousuarioschecked">
													<label class="form-check-label" for="relatoriousuarioschecked">
														Relatório de usuários
													</label>
												</div>
												</br>
												<div class="form-check">
													<?php 
														$checked =''; 
														if(isset($resultset["painel"])){
															if($resultset["painel"]==1){ 
																$checked ='checked="checked"';
															}  
														}	 
													?>
													<input class="form-check-input" type="checkbox" <?php echo isset($checked)? $checked:""; ?> value="1" id="painelchecked" name="painelchecked">
													<label class="form-check-label" for="defaultCheck1">
														Painel
													</label>
												</div>
											</ul>							
										</div>
									</div>
								</div>	
							</div>
						</div>
					</div>				
				</div>			
			</form>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="excluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="excluirLabel">Exclusão</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						Deseja realmente excluir esse registro?
					</div>
					<div class="modal-footer">          
						<button type="button" onclick="excluirImagem()" data-dismiss="modal" class="btn btn-primary">Ok</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
 
     <?php include("footer.php");?>
	  
    </main>

  </body>
</html>
<?php 
  $conexao->fecharConexao();
?>