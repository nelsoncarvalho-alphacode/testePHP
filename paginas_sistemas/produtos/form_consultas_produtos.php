<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<html>
 <head>
 	<meta charset="utf-8">
 <title>Consultas de Clientes</title>

<!-- Importação do BootStrap - CSS e JavaScript -->
  <link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../../css_js/css/estilo_produtos/estilo_form_consultas_produto.css">
 </head>
 <body>

<header>

	<h1 class="alert alert-secondary" role="alert" 
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">Consultas de Produtos
	</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_produtos.php"  class="btn btn-outline-secondary">
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
		<td class="bordas">Digite o código do produto</td>
		<td class="bordas">Digite o nome completo do produto</td>
		<td class="bordas">Digite o nome do produto (Procura por inicial)</td>
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
		<td class="bordas">Digite o modelo</td> 
		<td class="bordas">Digite o modelo (Procura por inicial)</td> 
		<td class="bordas">Digite o nome do fabricante</td> 
			<td></td>
	</tr>

	<tr>
		<td class="bordas"><input type="text" name="txt_modelo" size="50"></td> 
		<td class="bordas"><input type="text" name="txt_modelo_az" size="50"></td>
		<td class="bordas"><input type="text" name="txt_fabricante" size="50"></td>
		
		<td>

		</td>
	</tr>
</table>

</div>

</form>
</div>


<!-- Criando tabela e cabeçalho dos campos-->

<table class="table table-striped table-dark" style=" position: relative; top: -60px;">
	<tr class="bg-primary" >
 		<th style="text-align: center; width: 100px;">Foto</th>
 		<th style="text-align: center; width: 100px;">Código</th>
 		<th>Nome do produto</th>
 		<th>Descrição</th>
 		<th>Modelo</th>
 		<th>Fabricante</th>
 		<th>Observação</th>
 		<th>Data de fabricação</th>
 		<th>Valor por unidade</th>
 		<th>Quantidade em estoque</th>
 		<th>Data de validade</th>
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
	$modelo_procurado = $_POST['txt_modelo'];
	$modelo_procurado_az = $_POST['txt_modelo_az'];
	$fabricante_procurado = $_POST['txt_fabricante'];

// Script de consultas

// Consulta falsa... (Todos os input em branco)
$sql = "SELECT * FROM tb_cliente where cli_codigo = 0";

// Consultas por código
if($cod_procurado != "")
{ $sql = "SELECT * FROM tb_produto WHERE prod_codigo = $cod_procurado";  }

// Consultas por nome
if($nome_procurado != "")
{ $sql = "SELECT * FROM tb_produto WHERE prod_nome = '$nome_procurado'"; }

if($nome_procurado_az != "")
{ $sql = "SELECT * FROM tb_produto WHERE prod_nome  like '$nome_procurado_az%'"; }

// Consultas por e-mail
if($modelo_procurado != "")
{ $sql = "SELECT * FROM tb_produto WHERE prod_modelo = '$modelo_procurado'"; }

if($modelo_procurado != "")
{ $sql = "SELECT * FROM tb_produto WHERE prod_modelo like '$modelo_procurado_az%'"; }

if($fabricante_procurado != "")
{ $sql = "SELECT * FROM tb_produto WHERE prod_fabricante = '$fabricante_procurado'"; }



// mostrando valores encontrado

$resultado_consulta =  mysqli_query($conexao_servidor_bd, $sql)
or die
("<h5 class='alert alert-danger'>Erro na consulta...</h5>");
 
// Obtendo os dados por meio de um loop while
while($registros_consulta = mysqli_fetch_array($resultado_consulta))
{
	$foto_retorno = $registros_consulta['prod_foto'];
	$cod_retorno = $registros_consulta['prod_codigo'];
	$nome_retorno = $registros_consulta['prod_nome'];
	$descricao_retorno = $registros_consulta['prod_descricao'];
	$modelo_retorno = $registros_consulta['prod_modelo'];
	$fabricante_retorno = $registros_consulta['prod_fabricante'];
	$obs_retorno = $registros_consulta['prod_observacao'];
   $data_fabricacao_retorno = $registros_consulta['prod_data_fabricacao'];
   $valor_unidade_retorno = $registros_consulta['prod_valor_unidade'];
   $quant_estoque__retorno = $registros_consulta['prod_quant_estoque'];
	$data_validade_retorno = $registros_consulta['prod_data_validade'];

 echo "<tr>";
		 echo "<td style='text-align: center;'>" . 
		 "<img src='../../\img/fotos/fotos_produtos/$foto_retorno' id='img_alunos'>" . "</td>";

		 echo "<td style='font-size:40px; text-align: center; vertical-align: middle;'>" 
		 . $cod_retorno . "</td>";
		 echo "<td style='vertical-align: middle;'>" . $nome_retorno . "</td>";
		 echo "<td style='vertical-align: middle;'>" . $descricao_retorno . "</td>";
		 echo "<td style='vertical-align: middle;'>" . $modelo_retorno . "</td>";
		 echo "<td style='vertical-align: middle;'>" . $fabricante_retorno . "</td>";
		 echo "<td style='vertical-align: middle;'>" . $obs_retorno . "</td>";

//converter a data do mysql para o formato brasileiro.
$data_fabricacao_retorno = implode("/",array_reverse(explode("-",$data_fabricacao_retorno)));

		 echo "<td style='vertical-align: middle;'>" . $data_fabricacao_retorno . "</td>";
		 echo "<td style='vertical-align: middle;'>" . $valor_unidade_retorno . "</td>";
		 echo "<td style='vertical-align: middle;'>" . $quant_estoque__retorno . "</td>";
//converter a data do mysql para o formato brasileiro.
$data_validade_retorno = implode("/",array_reverse(explode("-",$data_validade_retorno)));
		 echo "<td style='vertical-align: middle;'>" . $data_validade_retorno . "</td>";
   echo "</tr>";
}

 mysqli_close($conexao_servidor_bd); 
 echo "</table>";
}

?>

</body>
</html>