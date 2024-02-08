<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("candidato.php");
include("candidatodao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

$totalregistros = 0 ;

if(!empty($_POST['acao']) && $_POST['acao']=="pesquisar"
   && (!empty($_POST['codigopesquisa']) || 
	   !empty($_POST['nomepesquisa']) ||
	   !empty($_POST['cpfpesquisa']) ||
	   !empty($_POST['cnpjpesquisa']) 
	  )
  ){
	$candidato = new Candidato();
	$candidatoDao = new CandidatoDAO($conexao);
	if(isset($_POST["codigopesquisa"])){
		$candidato->setIdCandidato($_POST["codigopesquisa"]);
	}
	if(isset($_POST["nomepesquisa"])){
		$candidato->setNome($_POST["nomepesquisa"]);
	}
	if(isset($_POST["cpfpesquisa"])){
		$candidato->setCpf($_POST["cpfpesquisa"]);
	}
	if(isset($_POST["cnpjpesquisa"])){
		$candidato->setCnpj($_POST["cnpjpesquisa"]);
	}
	$query = $candidatoDao->consultarCandidato($candidato);
	$totalregistros = $candidatoDao->getTotalRegistros($query);

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
	
	<script src="datatable/js/jquery.dataTables.min.js"></script>
	<script src="datatable/js/dataTables.bootstrap4.min.js"></script>
    <script src="datatable/css/dataTables.bootstrap4.min.css"></script>

	<script src="datatable/js/dataTables.buttons.min.js"></script>
	<script src="datatable/js/jszip.min.js"></script>
	<script src="datatable/js/pdfmake.min.js"></script>
	<script src="datatable/js/vfs_fonts.js"></script>
	<script src="datatable/js/buttons.html5.min.js"></script>
	  
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/funcoes.js"></script>
    <script src="js/menu.js"></script>
	
	<!-- Custom styles for this template -->
	<link href="css/mobile.css" rel="stylesheet">
	<link href="css/padding.css" rel="stylesheet">
	<link href="css/scroll.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
	<link href="css/sticky-footer-navbar.css" rel="stylesheet">
	
	<script>
	$(document).ready(function() {
		 $('#cpfpesquisa').mask('000.000.000-00', {reverse: true});
		 $('#cnpjpesquisa').mask('00.000.000/0000-00', {reverse: true});
		 $('#tabela').DataTable( {
					 "iDisplayLength": 20,
					"language": {
					"sEmptyTable":     "",
					"sInfo": "Mostrar _START_ até _END_ do _TOTAL_ registros",
					"sInfoEmpty": "Mostrar 0 até 0 de 0 Registros",
					"sInfoFiltered": "(Filtrar de _MAX_ total registros)",
					"sInfoPostFix":    "",
					"sInfoThousands":  ".",
					"sLengthMenu": "Mostrar _MENU_ registros por pagina",
					"sLoadingRecords": "Carregando...",
					"sProcessing":     "Processando...",
					"sZeroRecords": "",
					"sSearch": "Pesquisar: ",
					"oPaginate": {
						"sNext": "Proximo",
						"sPrevious": "Anterior",
						"sFirst": "Primeiro",
						"sLast":"Ultimo"
					},
					"oAria": {
						"sSortAscending":  ": Ordenar colunas de forma ascendente",
						"sSortDescending": ": Ordenar colunas de forma descendente"
					}			
				},
				dom: '<r<t><?php if(!empty($_POST['acao']) && $_POST['acao']=="pesquisar" && ($totalregistros>0)){ echo 'p'; }?>>',
				buttons: [
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5'
			   ],
		} );
	} );

	function prepararExclusao(idcandidato) {
	   formCandidato.idcandidato.value = idcandidato;
	}

	function pesquisar(){
	   formCandidato.acao.value = "pesquisar";
	   formCandidato.action = "candidatolista.php";
	   formCandidato.submit();				   
	}

	function editar(idcandidato){
	   formCandidato.idcandidato.value = idcandidato;
	   formCandidato.action = "candidatocadastro.php";
	   formCandidato.submit();	 
	}

	function novo(){
	   formCandidato.action = "candidatocadastro.php";
	   formCandidato.submit();
	}

	function excluir(){
	   formCandidato.acao.value = "excluir";
	   formCandidato.action = "candidatocontroller.php";
	   formCandidato.submit(); 		
	}
	 
	 $(document).ready(function() {
	    $('#nomepesquisa').keydown(function(event){
		  if(event.keyCode == 13){
			  pesquisar();
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

		<div id="lista" class="top col">
			Cadastro de candidato: 
			<form name="formCandidato"  method="post" >
				<input type="hidden" id="idcandidato" name="idcandidato" >
				<input type="hidden" id="acao" name="acao" >	
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Código"  id="codigopesquisa" name="codigopesquisa"  value="<?php  echo isset($_POST["codigopesquisa"]) ? $_POST["codigopesquisa"] : '';?>" autofocus>
					<input type="text" class="form-control" placeholder="Nome"  id="nomepesquisa" name="nomepesquisa"  value="<?php  echo isset($_POST["nomepesquisa"]) ? $_POST["nomepesquisa"] : '';?>">
					<input type="text" class="form-control" placeholder="Cpf"  id="cpfpesquisa" name="cpfpesquisa"  value="<?php  echo isset($_POST["cpfpesquisa"]) ? $_POST["cpfpesquisa"] : '';?>">
					<input type="text" class="form-control" placeholder="Cnpj"  id="cnpjpesquisa" name="cnpjpesquisa"  value="<?php  echo isset($_POST["cnpjpesquisa"]) ? $_POST["cnpjpesquisa"] : '';?>">
					<div class="input-group-append" id="button-addon4">
						<button type="button" onclick="pesquisar()" class="btn btn-outline-secondary">Pesquisar</button>  
						<button type="button" onclick="novo()" class="btn btn-outline-secondary">Novo</button>	  
					</div>
				</div>
				</br>
				<table id="tabela" class="table table-striped table-sm table-bordered">
					<thead>
						<tr>
							<th style="width:20%">Código</th>
							<th style="width:40%">Nome</th>
							<th style="width:20%">Endereço</th>
							<th style="width:20%">Ação</th>
						</tr>
					</thead>
					<tbody>	
					<?php
                        if(!empty($_POST['acao']) && $_POST['acao']=="pesquisar"
						   && (!empty($_POST['codigopesquisa']) || 
							   !empty($_POST['nomepesquisa']) ||
							   !empty($_POST['cpfpesquisa']) ||
							   !empty($_POST['cnpjpesquisa']) 
							  )
						  ){
							while($resultset = $candidatoDao->listarCandidato($query))
							{
					?>
						<tr>
							<td><?php echo $resultset["idcandidato"];?></td>
							<td><?php echo $resultset["nome"];?></td>
							<td><?php echo $resultset["endereco"];?></td>
							<td>
								<button type="button" class="btn btn-outline-secondary" style="width: 70px" onclick="editar(<?php echo $resultset["idcandidato"];?>)">Editar</button>
                                <button type="button" class="btn btn-outline-secondary" style="width: 70px" onclick="prepararExclusao(<?php echo $resultset["idcandidato"];?>)" data-toggle="modal" data-target="#excluir">Excluir</button>
							</td>
						</tr>
					<?php 
							}
						}	
					?>			
					</tbody>
				</table>

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
								<button type="button" onclick="excluir()" data-dismiss="modal" class="btn btn-primary">Ok</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							</div>
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