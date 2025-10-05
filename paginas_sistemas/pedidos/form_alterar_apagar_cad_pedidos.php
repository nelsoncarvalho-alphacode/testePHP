<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<html>
 <head>
 	<meta charset="utf-8">
 <title>Alterar ou Apagar Pedidos</title>

<!-- Importação do BootStrap - CSS e JavaScript -->
  <link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../../css_js/css/estilo_pedidos/estilo_form_consultas_pedido.css">

  <script type="text/javascript">

	function pergunta_alterar_registro(cod)
	{ return confirm('Código selecionado: ' + cod + '\n\n' + 'Deseja realmente alterar o registro de pedido selecionado?'); } 

	function pergunta_apagar_registro(cod)
	{ return confirm('Código selecionado: ' + cod + '\n\n' + 'Deseja realmente apagar o registro de pedido selecionado?'); 	} 
</script>

 </head>
 <body>

<header>

	<h1 class="alert alert-secondary" role="alert" 
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">Alterar ou apagar registros de Pedidos
	</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_pedidos.php"  class="btn btn-outline-secondary">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>			
		<a href="form_alterar_apagar_cad_pedidos.php"  class="btn btn-outline-secondary" title="Atualizar relatório">
			<img src="../../img/icones/icones_acp/atualizar.png" style="width: 40px; height: 40px;">
		</a>
    </nav>
</header>




<!-- Criando tabela e cabeçalho dos campos-->

<table class="table table-striped table-dark" style=" position: relative; top: -55px">
	<tr class="bg-primary" >
		<th>Código do pedido</th>
 		<th>Nome do cliente</th>
 		<th>Código do cliente</th>
 		<th>CPF</th>
 		<th>E-mail</th>
 		<th>Data do pedido</th>
 		<th>Hora do pedido</th>
 		<th>Nome do produto</th>
 		<th>Código de barras</th>
 		<th>Valor por unidade</th>
		<th>Quantidade comprada</th>
		<th>Total</th>
		<th>Alterar ou apagar registros</th>
 	</tr>

 <!-- Preenchendo a tabela com os dados do banco: -->
<?php

include("../../conexao_bd_mysql/conexao_bd_mysql.php");

$cod_procurado = null;
$nome_procurado = null;
$nome_procurado_az = null;
$cpf_procurado = null;
$data_pedido_procurado_az = null;
$mes_pedido_procurado = null;

if($_POST)
{

// Recebendo dados procurados
$cod_procurado = $_POST['txt_codigo'];
$nome_procurado = $_POST['txt_nome'];
$nome_procurado_az = $_POST['txt_nome_az'];
$cpf_procurado = $_POST['txt_cpf'];
$data_pedido_procurado_az = $_POST['txt_data_pedido'];
$mes_pedido_procurado = $_POST['txt_mes_pedido'];

}

// Script de consultas

// Relatório incial
$sql = "SELECT * FROM tb_pedido;";

// Consultas por código
if($cod_procurado != "")
{ $sql = "SELECT * FROM tb_pedido WHERE ped_codigo = $cod_procurado";  }

// Consultas por nome
if($nome_procurado != "")
{ $sql = "SELECT * FROM tb_pedido WHERE ped_nome_cliente = '$nome_procurado'"; }

if($nome_procurado_az != "")
{ $sql = "SELECT * FROM tb_pedido WHERE ped_nome_cliente  like '$nome_procurado_az%'"; }

// Consultas por CPF
if($cpf_procurado != "")
{ $sql = "SELECT * FROM tb_pedido WHERE ped_cpf = '$cpf_procurado'"; }

// Consultas por DATA
if($data_pedido_procurado_az != "")
{ $sql = "SELECT * FROM tb_pedido WHERE ped_data_pedido like '$data_pedido_procurado_az%'"; }

// Consultas por MÊS
if($mes_pedido_procurado != "")
{ 	$sql = "SELECT * FROM tb_pedido WHERE ped_data_pedido like '$mes_pedido_procurado%'"; }



// mostrando valores encontrado

$resultado_consulta =  mysqli_query($conexao_servidor_bd, $sql)
or die
("<h5 class='alert alert-danger'>Erro na consulta...</h5>");
 
// Obtendo os dados por meio de um loop while
while($registros_consulta = mysqli_fetch_array($resultado_consulta))
{
	$cod_pedido_retorno = $registros_consulta['ped_codigo'];
	$nome_cliente_retorno = $registros_consulta['ped_nome_cliente'];
	$cod_cliente_retorno = $registros_consulta['ped_cod_cliente'];
	$cpf_retorno = $registros_consulta['ped_cpf'];
	$email_retorno = $registros_consulta['ped_email'];
	$data_pedido_retorno = $registros_consulta['ped_data_pedido'];
	$hora_pedido_retorno = $registros_consulta['ped_hora_pedido'];
	$nome_produto_retorno = $registros_consulta['ped_nome_produto'];
	$cod_barra__retorno = $registros_consulta['ped_cod_barra'];
	$valor_unidade_retorno = $registros_consulta['ped_valor_unidade'];
	$quant_comprada_retorno = $registros_consulta['ped_quant_comprada'];

 echo "<tr>";
	echo "<td style='font-size:40px; text-align: center; vertical-align: middle;'>" . $cod_pedido_retorno . "</td>";
	echo "<td style='vertical-align: middle;'>" . $nome_cliente_retorno . "</td>";
	echo "<td style='vertical-align: middle;'>" . $cod_cliente_retorno . "</td>";
	echo "<td style='vertical-align: middle;'>" . $cpf_retorno . "</td>";
	echo "<td style='vertical-align: middle;'>" . $email_retorno . "</td>";

//converter a data do mysql para o formato brasileiro.
$data_pedido_retorno = implode("/",array_reverse(explode("-",$data_pedido_retorno)));

	echo "<td style='vertical-align: middle;'>" . $data_pedido_retorno . "</td>";
	echo "<td style='vertical-align: middle;'>" . $hora_pedido_retorno . "</td>";
	echo "<td style='vertical-align: middle;'>" . $nome_produto_retorno . "</td>";
	echo "<td style='vertical-align: middle;'>" . $cod_barra__retorno . "</td>";
	echo "<td style='vertical-align: middle;'>" . 'R$ ' . number_format($valor_unidade_retorno, 2, ',', '.') . "</td>";
	echo "<td style='vertical-align: middle;'>" . $quant_comprada_retorno . "</td>";

	$total =  $valor_unidade_retorno * $quant_comprada_retorno;

	echo "<td style='vertical-align: middle;'>" . 'R$ ' . number_format($total, 2, ',', '.') . "</td>";

	 // Fomulário para alterar e apagar cadastro de aluno
	echo "<td>" . "
<form name='form_aleteracao' action='form_alterar_cadastro_pedido.php' method='POST' style='float:left;'>				
	<input type='hidden' name='txt_cod_selecionado' value= '$cod_pedido_retorno'>
	<input type='hidden' name='txt_nome_cliente' value= '$nome_cliente_retorno'>
	<input type='hidden' name='txt_cod_cliente' value= '$cod_cliente_retorno'>
	<input type='hidden' name='txt_cpf' value= '$cpf_retorno'>
	<input type='hidden' name='txt_email' value= '$email_retorno'>
	<input type='hidden' name='txt_data_pedido' value= '$data_pedido_retorno'>
	<input type='hidden' name='txt_hora_pedido' value= '$hora_pedido_retorno'>
	<input type='hidden' name='txt_nome_produto' value= '$nome_produto_retorno'>
	<input type='hidden' name='txt_cod_barras' value= '$cod_barra__retorno'>
	<input type='hidden' name='txt_valor_unidade' value= '$valor_unidade_retorno'>
	<input type='hidden' name='txt_quant_comprada' value= '$quant_comprada_retorno'>

	<input type='submit' name='botao_alterar' value='Alterar' class='btn btn-outline-warning' 
	onclick='return pergunta_alterar_registro($cod_pedido_retorno);'/>
</form>


<form name='form_del' action='apagar_cadastro_pedido_bd.php' method='POST' style='float:left; position:relative; margin-left: 10px;'>

	<input type='hidden' name='txt_cod_selecionado' value= '$cod_pedido_retorno'>

	<input type='submit' name='botao_deletar' value='Apagar' class='btn btn-outline-danger'
	 onclick='return pergunta_apagar_registro($cod_pedido_retorno);'/>
</form>" . "</td>";

   echo "</tr>";
}

 mysqli_close($conexao_servidor_bd); 
 echo "</table>";

?>

</body>
</html>