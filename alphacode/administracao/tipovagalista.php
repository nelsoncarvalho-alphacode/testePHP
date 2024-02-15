<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("tipovaga.php");
include("tipovagadao.php");

$conexao = new Conexao();
$conexao->abrirConexao();

$totalregistros = 0;

if(!empty($_POST['acao']) && $_POST['acao']=="pesquisar"
  && !empty($_POST['tipopesquisa'])){
	$tipoVaga = new TipoVaga();
	$tipoVagaDao = new TipoVagaDAO($conexao);
	if(isset($_POST["tipopesquisa"])){
		$tipoVaga->setTipo($_POST["tipopesquisa"]);
	}
	$query = $tipoVagaDao->consultarTipoVaga($tipoVaga);
	$totalregistros = $tipoVagaDao->getTotalRegistros($query);
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

    function prepararExclusao(idtipovaga) {
      formTipoVaga.idtipovaga.value = idtipovaga;
    }

    function pesquisar(){
      formTipoVaga.acao.value = "pesquisar";
      formTipoVaga.action = "tipovagalista.php";
      formTipoVaga.submit();				   

    }

    function editar(idtipovaga){
      formTipoVaga.idtipovaga.value = idtipovaga;
      formTipoVaga.action = "tipovagacadastro.php";
      formTipoVaga.submit();	 
    }

    function novo(){
      formTipoVaga.action = "tipovagacadastro.php";
      formTipoVaga.submit();
    }

    function excluir(){
        formTipoVaga.acao.value = "excluir";
        formTipoVaga.action = "tipovagacontroller.php";
        formTipoVaga.submit(); 		
    }

    $(document).ready(function() {
        $('#tipovagapesquisa').keydown(function(event){
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
		Cadastro de tipo de vaga: 
		<form name="formTipoVaga" method="post" >
			<input type="hidden" id="idtipovaga" name="idtipovaga" >
			<input type="hidden" id="acao" name="acao" >	
		       <div class="input-group">
			        <input type="text" class="form-control" placeholder="tipo de vaga"  id="tipopesquisa" name="tipopesquisa"  value="<?php  echo isset($_POST["tipopesquisa"]) ? $_POST["tipopesquisa"] : '';?>" autofocus>
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
						    <th style="width:40%">Tipo</th>
							<th style="width:20%">Ação</th>
						</tr>
					</thead>
					<tbody>	
					<?php 
						if(!empty($_POST['acao']) && $_POST['acao']=="pesquisar" && !empty($_POST['tipopesquisa'])){
							while($resultset = $tipoVagaDao->listarTipoVaga($query))
							{
					?>
						<tr>
							<td><?php echo $resultset["idtipovaga"];?></td>
							<td><?php echo $resultset["tipo"];?></td>
							<td>
								<button type="button" class="btn btn-outline-secondary" style="width: 70px" onclick="editar(<?php echo $resultset["idtipovaga"];?>)">Editar</button>
								<button type="button" class="btn btn-outline-secondary" style="width: 70px" onclick="prepararExclusao(<?php echo $resultset["idtipovaga"];?>)" data-toggle="modal" data-target="#excluir">Excluir</button>
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