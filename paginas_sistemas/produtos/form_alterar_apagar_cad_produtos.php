<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<!DOCTYPE html>
<html>
<head>
	<!-- Código para atualizar a página atual em 60 segundos-->
    <meta http-equiv="refresh" content="60;url=form_alterar_apagar_cad_produtos.php">

	<meta charset="utf-8">
	<title>ACP - Alterar ou apagar registro de Produto</title>

<!-- Importação do BootStrap - CSS e JavaScript -->
  <link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>


  <link rel="stylesheet" href="../../css_js/css/estilo_produtos/estilo_form_alterar_cad_produto.css">

<script type="text/javascript">

	function pergunta_alterar_registro(cod)
	{ 
	 return confirm('Código selecionado: ' + cod + '\n\n' + 'Deseja realmente alterar o registro do cliente selecionado?'); 
	} 

	function pergunta_apagar_registro(cod)
	{ 
	 return confirm('Código selecionado: ' + cod + '\n\n' + 'Deseja realmente apagar o registro do cliente selecionado?'); 
	} 
</script>

</head>
<body>
	
 <header>
	<h1 class="alert alert-secondary" role="alert" 
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">Alterar ou apagar registros de Produto</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_produtos.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>		
		<a href="form_alterar_apagar_cad_produtos.php"  class="btn btn-outline-secondary" title="Atualizar relatório">
			<img src="../../img/icones/icones_acp/atualizar.png" style="width: 40px; height: 40px;">
		</a>	
    </nav>
</header>

<!-- Criando tabela e cabeçalho de dados: -->


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
		<th>Alterar ou apagar registros</th>
 	</tr>

<!-- Preenchendo a tabela com os dados do banco: -->
<?php

include("../../conexao_bd_mysql/conexao_bd_mysql.php");

 // Consulta para selecionar todos os campos da tb_clientes
	
	$consulta_sql = "SELECT * FROM tb_produto order by prod_codigo desc;";

// Execução do relatório no BD

$resultado_relatorio = mysqli_query($conexao_servidor_bd, $consulta_sql)
or die
("<h5 class='alert alert-danger'>Erro de relatório: O relatório não foi realizado.</h5>");


// Obtendo os dados por meio de um loop while
 while($registros_relatorio = mysqli_fetch_array($resultado_relatorio))
 {
 	$foto_retorno = $registros_relatorio['prod_foto'];
 	$cod_retorno = $registros_relatorio['prod_codigo'];
 	$nome_retorno = $registros_relatorio['prod_nome'];
 	$descricao_retorno = $registros_relatorio['prod_descricao'];
 	$modelo_retorno = $registros_relatorio['prod_modelo'];
 	$fabricante_retorno = $registros_relatorio['prod_fabricante'];
 	$obs_retorno = $registros_relatorio['prod_observacao'];
	$data_fabricacao_retorno = $registros_relatorio['prod_data_fabricacao'];

	$data_fabricacao_retorno = $data_fabricacao_retorno;

	$valor_unidade_retorno = $registros_relatorio['prod_valor_unidade'];
	$quant_estoque__retorno = $registros_relatorio['prod_quant_estoque'];
 	$data_validade_retorno = $registros_relatorio['prod_data_validade'];


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
	   	
 // Fomulário para alterar e apagar cadastro de aluno
	echo "<td>" . "
<form name='form_aleteracao' action='form_alterar_cadastro_produto.php' method='POST' style='float:left;'>				
	<input type='hidden' name='txt_cod_selecionado' value= '$cod_retorno'>
	<input type='hidden' name='txt_nome' value= '$nome_retorno'>
	<input type='hidden' name='txt_descricao' value= '$descricao_retorno'>
	<input type='hidden' name='txt_modelo' value= '$modelo_retorno'>
	<input type='hidden' name='txt_fabricante' value= '$fabricante_retorno'>
	<input type='hidden' name='txt_obs' value= '$obs_retorno'>
	<input type='hidden' name='txt_data_fabricacao' value= '$data_fabricacao_retorno'>
	<input type='hidden' name='txt_tamanho' value= '$valor_unidade_retorno'>
	<input type='hidden' name='txt_num_registro' value= '$quant_estoque__retorno'>
	<input type='hidden' name='txt_data_validade' value= '$data_validade_retorno'>
	<input type='hidden' name='txt_end_foto' value= '$foto_retorno'>

	<input type='submit' name='botao_alterar' value='Alterar' class='btn btn-outline-warning' 
	onclick='return pergunta_alterar_registro($cod_retorno);'/>
</form>


<form name='form_del' action='apagar_cadastro_produto_bd.php' method='POST' style='float:left; position:relative; margin-left: 10px;'>

	<input type='hidden' name='txt_cod_selecionado' value= '$cod_retorno'>
	<input type='hidden' name='txt_end_foto_apagar' value= '$foto_retorno'>

	<input type='submit' name='botao_deletar' value='Apagar' class='btn btn-outline-danger' onclick='return pergunta_apagar_registro($cod_retorno);'/>
</form>" . "</td>";
echo "</tr>";

 }

echo "</table>";

mysqli_close($conexao_servidor_bd);


?>

</body>
</html>