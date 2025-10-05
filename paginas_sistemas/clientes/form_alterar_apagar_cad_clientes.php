<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<!DOCTYPE html>
<html>
<head>
	<!-- Código para atualizar a página atual em 60 segundos-->
    <meta http-equiv="refresh" content="60;url=form_alterar_apagar_cad_clientes.php">

	<meta charset="utf-8">
	<title>ACP - Alterar ou apagar registro de Cliente</title>

<!-- Importação do BootStrap - CSS e JavaScript -->
  <link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../../css_js/css/estilo_clientes/estilo_form_alterar_cad_cliente.css">

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
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">Alterar ou apagar registros de cliente</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_clientes.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>		
		<a href="form_alterar_apagar_cad_clientes.php"  class="btn btn-outline-secondary" title="Atualizar relatório">
			<img src="../../img/icones/icones_acp/atualizar.png" style="width: 40px; height: 40px;">
		</a>	
    </nav>
</header>

<!-- Criando tabela e cabeçalho de dados: -->


<table class="table table-striped table-dark" style="position: relative; top:-60px;">
	<tr class="bg-primary">
 		<th style="text-align: center; width: 100px;">Foto</th>
 		<th style="text-align: center; width: 100px;">Código</th>
 		<th>Nome</th>
 		<th>Endereço</th>
 		<th>Telefone</th>
 		<th>Celular</th>
 		<th>E-mail</th>
 		<th>Data de nascimento</th>
 		<th>RG</th>
 		<th>CPF</th>
 		<th>Código da Turma</th>
		<th>Alterar ou apagar registros</th>
 	</tr>

<!-- Preenchendo a tabela com os dados do banco: -->
<?php

include("../../conexao_bd_mysql/conexao_bd_mysql.php");

 // Consulta para selecionar todos os campos da tb_clientes
	
	$consulta_sql = "SELECT * FROM tb_cliente order by cli_codigo desc;";

// Execução do relatório no BD

$resultado_relatorio = mysqli_query($conexao_servidor_bd, $consulta_sql)
or die
("<h5 class='alert alert-danger'>Erro de relatório: O relatório não foi realizado.</h5>");


// Obtendo os dados por meio de um loop while
 while($registros_relatorio = mysqli_fetch_array($resultado_relatorio))
 {
 	$foto_retorno = $registros_relatorio['cli_foto'];
 	$cod_cliente_retorno = $registros_relatorio['cli_codigo'];
 	$nome_retorno = $registros_relatorio['cli_nome'];
 	$endereco_retorno = $registros_relatorio['cli_endereco'];
 	$telefone_retorno = $registros_relatorio['cli_telefone'];
 	$celular_retorno = $registros_relatorio['cli_celular'];
 	$email_retorno = $registros_relatorio['cli_email'];
	$data_nascimento_retorno = $registros_relatorio['cli_data_nascimento'];

	$data_nascimento_retorno_original = $data_nascimento_retorno;

	$rg_retorno = $registros_relatorio['cli_rg'];
	$cpf_retorno = $registros_relatorio['cli_cpf'];
 	$data_cadastro_retorno = $registros_relatorio['cli_data_cad_cliente'];


echo "<tr>";
  		echo "<td style='text-align: center;'>" . 
  		"<img src='../../img/fotos/fotos_clientes/$foto_retorno' id='img_alunos'>" . "</td>";
  		

  		echo "<td style='font-size:40px; text-align: center; vertical-align: middle;'>" 
  		. $cod_cliente_retorno . "</td>";
  		echo "<td style='vertical-align: middle;'>" . $nome_retorno . "</td>";
  		echo "<td style='vertical-align: middle;'>" . $endereco_retorno . "</td>";
  		echo "<td style='vertical-align: middle;'>" . $telefone_retorno . "</td>";
  		echo "<td style='vertical-align: middle;'>" . $celular_retorno . "</td>";
  		echo "<td style='vertical-align: middle;'>" . $email_retorno . "</td>";

//converter a data do mysql para o formato brasileiro.
 $data_nascimento_retorno = implode("/",array_reverse(explode("-",$data_nascimento_retorno)));

	echo "<td style='vertical-align: middle;'>" . $data_nascimento_retorno . "</td>";
	echo "<td style='vertical-align: middle;'>" . $rg_retorno . "</td>";
	echo "<td style='vertical-align: middle;'>" . $cpf_retorno . "</td>";
//converter a data do mysql para o formato brasileiro.
 $data_cadastro_retorno = implode("/",array_reverse(explode("-",$data_cadastro_retorno)));

	echo "<td style='vertical-align: middle;'>" . $data_cadastro_retorno . "</td>";
	   	
 // Fomulário para alterar e apagar cadastro de aluno
	echo "<td>" . "
<form name='form_aleteracao' action='form_alterar_cadastro_cliente.php' method='POST' style='float:left;'>				
	<input type='hidden' name='txt_cod_selecionado' value= '$cod_cliente_retorno'>
	<input type='hidden' name='txt_nome' value= '$nome_retorno'>
	<input type='hidden' name='txt_endereco' value= '$endereco_retorno'>
	<input type='hidden' name='txt_telefone' value= '$telefone_retorno'>
	<input type='hidden' name='txt_celular' value= '$celular_retorno'>
	<input type='hidden' name='txt_email' value= '$email_retorno'>
	<input type='hidden' name='txt_data_nascimento' value= '$data_nascimento_retorno_original'>
	<input type='hidden' name='txt_rg' value= '$rg_retorno'>
	<input type='hidden' name='txt_cpf' value= '$cpf_retorno'>
	<input type='hidden' name='txt_data_cadastro' value= '$data_cadastro_retorno'>
	<input type='hidden' name='txt_end_foto' value= '$foto_retorno'>

	<input type='submit' name='botao_alterar' value='Alterar' class='btn btn-outline-warning' 
	onclick='return pergunta_alterar_registro($cod_cliente_retorno);'/>
</form>


<form name='form_del' action='apagar_cadastro_cliente_bd.php' method='POST' style='float:left; position:relative; margin-left: 10px;'>

	<input type='hidden' name='txt_cod_selecionado' value= '$cod_cliente_retorno'>
	<input type='hidden' name='txt_end_foto_apagar' value= '$foto_retorno'>

	<input type='submit' name='botao_deletar' value='Apagar' class='btn btn-outline-danger' onclick='return pergunta_apagar_registro($cod_cliente_retorno);'/>
</form>"

. "</td>";
echo "</tr>";

 }

echo "</table>";

mysqli_close($conexao_servidor_bd);

?>

</body>
</html>