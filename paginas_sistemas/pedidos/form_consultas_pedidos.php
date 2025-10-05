<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<html>
 <head>
 	<meta charset="utf-8">
 <title>Consultas de Pedidos</title>

<!-- Importação do BootStrap - CSS e JavaScript -->
  <link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../../css_js/css/estilo_pedidos/estilo_form_consultas_pedido.css">
 </head>
 <body>

<header>

	<h1 class="alert alert-secondary" role="alert" 
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">Consultas de Pedidos
	</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_pedidos.php"  class="btn btn-outline-secondary">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>			
    </nav>
</header>

<div id="div_alinhar_tabela" 
style="height: 160px; margin: 0; text-align: center;  position: relative; margin: auto; top:-55px;  width: 100%;"
 class="alert alert-secondary" role="alert">

<div>
		
<form method="POST" name="form_procurar_codigo_nome" >
			
  <table id="tab_consultas">
	<!-- Linha é o tr -->
	<!-- Coluna é o td -->
		
	<tr style="background:#afb9bd;" class="bordas"> 
		<td class="bordas">Digite o código do Pedido</td>
		<td class="bordas">Digite o nome completo do cliente</td>
		<td class="bordas">Digite o nome do cliente (Procura por inicial do nome)</td>
			<td>Procurar</td>
	</tr>

	<tr>
		<td class="bordas"><input type="number" name="txt_codigo" autofocus="" min="0" style="width: 100%;"></td>
		<td class="bordas"><input type="text" name="txt_nome" size="50"></td>
		<td class="bordas"><input type="text" name="txt_nome_az" size="50"></td>
		
		<td  rowspan="4">
			<button type="submit" title="Procurar" class="btn btn-dark" 
			style="width: 70px; height: 80px;">
				<img src="../../img/icones/icones_acp/procurar.png" alt="Procurar" 
				style="width: 90px; height: 90px; margin-left: -15px;" >
			</button>
		</td>
	</tr>

	<tr> 
		<td colspan="3" style="height: 5px; background: #000;"></td> 
	</tr>

	<tr style="background:#afb9bd;"> 
		<td class="bordas">Digite o CPF</td> 
		<td class="bordas">Selecione a data do pedido</td> 
		<td class="bordas">Selecione o mês e ano do pedido</td> 
			<td></td>
	</tr>

	<tr>
		<td class="bordas"><input type="text" name="txt_cpf" size="50"></td> 
		<td class="bordas"><input type="date" name="txt_data_pedido" size="50" style="width: 100%;"></td>
		<td class="bordas"><input type="month" name="txt_mes_pedido" size="50" style="width: 100%;"></td>		
	</tr>
</table>

</div>

</form>
</div>


<!-- Criando tabela e cabeçalho dos campos-->

<table class="table table-striped table-dark" style=" position: relative; top: -60px;">
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
 	</tr>

 <!-- Preenchendo a tabela com os dados do banco: -->
<?php

include("../../conexao_bd_mysql/conexao_bd_mysql.php");

if($_POST)
{

// Recebendo dados procurados
$cod_procurado = $_POST['txt_codigo'];
$nome_procurado = $_POST['txt_nome'];
$nome_procurado_az = $_POST['txt_nome_az'];
$cpf_procurado = $_POST['txt_cpf'];
$data_pedido_procurado_az = $_POST['txt_data_pedido'];
$mes_pedido_procurado = $_POST['txt_mes_pedido'];

// Script de consultas

// Consulta falsa... (Todos os input em branco)
$sql = "SELECT * FROM tb_pedido where ped_codigo = 0";

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

   echo "</tr>";
}

 mysqli_close($conexao_servidor_bd); 
 echo "</table>";
}

?>

</body>
</html>