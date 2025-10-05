<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<html>
 <head>
 	<meta charset="utf-8">
 <title>Relatórios de Clientes</title>

<!-- Código para atualizar a página a cada 60 segundos -->
<meta http-equiv='refresh' content='60;url=form_relatorios_clientes.php'>

<!-- Importação do BootStrap - CSS e JavaScript -->
  <link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../../css_js/css/estilo_produtos/estilo_form_relatorios_produto.css">
 </head>
 <body>

 <header>
	<h1 class="alert alert-secondary" role="alert" 
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">
		Relatório de Produtos</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_produtos.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>		
		<a href="form_relatorios_produtos.php"  class="btn btn-outline-secondary" title="Atualizar relatório">
			<img src="../../img/icones/icones_acp/atualizar.png" style="width: 40px; height: 40px;">
		</a>	
    </nav>
</header>


<!-- Criando tabela e cabeçalho dos campos-->

<table class="table table-striped table-dark" style="position: relative; top:-60px;">
	<tr class="bg-primary">
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

// Lista todos os alunos cadastrado na tabela
$sql = "SELECT * FROM tb_produto order by prod_codigo desc";

// mostrando valores encontrado na tabela

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
  		"<img src='../../img/fotos/fotos_produtos/$foto_retorno' id='img_produtos'>" . "</td>";
  		

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

$foto_retorno = null;

 mysqli_close($conexao_servidor_bd); 
 echo "</table>";

?>

</body>
</html>