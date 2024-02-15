<?php
session_start();
include("seguranca.php");
include("conexao.php");
include "centrodecusto.php";
include "centrodecustodao.php";

$conexao = new Conexao();
$conexao->abrirConexao();

$totalregistros = 0;

if(!empty($_POST['acao']) && $_POST['acao']=="pesquisar" && !empty($_POST['centrodecustopesquisa'])){
	$centroDeCusto = new CentroDeCusto();
	$centroDeCustoDao = new CentroDeCustoDAO($conexao);
	if(isset($_POST["centrodecustopesquisa"])){
		$centroDeCusto->setCentroDeCusto($_POST["centrodecustopesquisa"]);
	}
	$query = $centroDeCustoDao->consultarCentroDeCusto($centroDeCusto);
	$totalregistros = $centroDeCustoDao->getTotalRegistros($query);
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
	
    <script src="js/menu.js"></script>
	 
	<!-- Custom styles for this template -->
	<link href="css/mobile.css" rel="stylesheet">
	<link href="css/padding.css" rel="stylesheet">
	<link href="css/scroll.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
	<link href="css/sticky-footer-navbar.css" rel="stylesheet">
	
	<script>
		
	$(document).ready(function() {
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
		

	function prepararExclusao(idcentrodecusto) {
	   formCentroDeCusto.idcentrodecusto.value = idcentrodecusto;
	}

	function pesquisar(){
	   formCentroDeCusto.acao.value = "pesquisar";
	   formCentroDeCusto.action = "centrodecustolista.php";
	   formCentroDeCusto.submit();				   
	}

	function editar(idcentrodecusto){
	   formCentroDeCusto.idcentrodecusto.value = idcentrodecusto;
	   formCentroDeCusto.action = "centrodecustocadastro.php";
       formCentroDeCusto.submit();	 
	}

	function novo(){
	   formCentroDeCusto.action = "centrodecustocadastro.php";
	   formCentroDeCusto.submit();
	}

	function excluir(){
	   formCentroDeCusto.acao.value = "excluir";
	   formCentroDeCusto.action = "centrodecustocontroller.php";
	   formCentroDeCusto.submit(); 		
	}
	
	$(document).ready(function() {
	    $('#centrodecustopesquisa').keydown(function(event){
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
			Cadastro de centro de custo: 
			<form name="formCentroDeCusto" method="post" >
				<input type="hidden" id="idcentrodecusto" name="idcentrodecusto" >
				<input type="hidden" id="acao" name="acao">				
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Centro de custo"  id="centrodecustopesquisa" name="centrodecustopesquisa"  value="<?php  echo isset($_POST["centrodecustopesquisa"]) ? $_POST["centrodecustopesquisa"] : '';?>" autofocus>
					<div class="input-group-append" >
				  	    <button type="button" onclick="pesquisar()" class="btn btn-outline-secondary">Pesquisar</button>  
						<button type="button" onclick="novo()" class="btn btn-outline-secondary">Novo</button>	  
					</div>
				</div>
				</br>			
				<table id="tabela" class="table table-striped table-sm table-bordered" >
					<thead>
						<tr>
							<th style="width:20%">Código</th>
							<th style="width:40%">Centro de custo</th>
							<th style="width:20%">Endereço</th>
							<th style="width:20%">Ação</th>
						</tr>
					</thead>
					<tbody>	
					<?php 
						if(!empty($_POST['acao']) && $_POST['acao']=="pesquisar" && !empty($_POST['centrodecustopesquisa'])){
							while($resultset = $centroDeCustoDao->listarCentroDeCusto($query))
							{
					?>
						<tr>
							<td><?php echo $resultset["idcentrodecusto"];?></td>
							<td><?php echo $resultset["centrodecusto"];?></td>
							<td><?php echo $resultset["endereco"];?></td>
							<td>
								<button type="button" class="btn btn-outline-secondary" style="width: 70px" onclick="editar(<?php echo $resultset["idcentrodecusto"];?>)">Editar</button>
								<button type="button" class="btn btn-outline-secondary" style="width: 70px" onclick="prepararExclusao(<?php echo $resultset["idcentrodecusto"];?>)" data-toggle="modal" data-target="#excluir">Excluir</button>
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

	<script>
		$('.navbar-nav li a').click(function() {
		  if ( !$(this).parent().hasClass('dropdown')) {
		   $('.navbar-collapse').collapse('hide'); 
		  }
	   }); 		
	 
		//voltar ao topo  
		$(document).ready(function() {
			if ($(this).scrollTop() <= 150) {
				$("#topo").hide();
			}
		});	
		
		$(document).scroll(function() {  	
			if ($(this).scrollTop() > 150) {
				$("#topo").show();
			}else{
				$("#topo").hide();  	
			}   
		});   
	</script>
	   
  </body>
</html>
<?php 
$conexao->fecharConexao();
?>