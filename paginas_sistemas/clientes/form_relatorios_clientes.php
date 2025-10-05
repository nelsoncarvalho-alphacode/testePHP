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

  <link rel="stylesheet" href="../../css_js/css/estilo_clientes/estilo_form_relatorios_cliente.css">
 </head>
 <body>

 <header>
	<h1 class="alert alert-secondary" role="alert" 
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">
		Relatório de Clientes</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_clientes.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>		
		<a href="form_relatorios_clientes.php"  class="btn btn-outline-secondary" title="Atualizar relatório">
			<img src="../../img/icones/icones_acp/atualizar.png" style="width: 40px; height: 40px;">
		</a>	
    </nav>
</header>


<!-- Criando tabela e cabeçalho dos campos-->

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
 		<th>Data do cadastro</th>
 	</tr>

 <!-- Preenchendo a tabela com os dados do banco: -->
<?php

include("../../conexao_bd_mysql/conexao_bd_mysql.php");

// Lista todos os alunos cadastrado na tabela
$sql = "SELECT * FROM tb_cliente order by cli_codigo desc";

// mostrando valores encontrado na tabela

$resultado_consulta =  mysqli_query($conexao_servidor_bd, $sql)
or die
("<h5 class='alert alert-danger'>Erro na consulta...</h5>");
 
// Obtendo os dados por meio de um loop while
while($registros_consulta = mysqli_fetch_array($resultado_consulta))
{
	$foto_retorno = $registros_consulta['cli_foto'];
	$cod_aluno_retorno = $registros_consulta['cli_codigo'];
	$nome_retorno = $registros_consulta['cli_nome'];
	$endereco_retorno = $registros_consulta['cli_endereco'];
	$telefone_retorno = $registros_consulta['cli_telefone'];
	$celular_retorno = $registros_consulta['cli_celular'];
	$email_retorno = $registros_consulta['cli_email'];
   $data_nascimento_retorno = $registros_consulta['cli_data_nascimento'];
   $rg_retorno = $registros_consulta['cli_rg'];
   $cpf_retorno = $registros_consulta['cli_cpf'];
	$data_cadastro_retorno = $registros_consulta['cli_data_cad_cliente'];

	if($foto_retorno == null)
	{$foto_retorno = "foto_padrao.png"; }

 echo "<tr>";
		 echo "<td style='text-align: center;'>" . 
		 "<img src='../../img/fotos/fotos_clientes/$foto_retorno' id='img_alunos'>" . "</td>";

		 echo "<td style='font-size:40px; text-align: center; vertical-align: middle;'>" 
		 . $cod_aluno_retorno . "</td>";
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


   echo "</tr>";

$foto_retorno = null;

}

 mysqli_close($conexao_servidor_bd); 
 echo "</table>";
?>

</body>
</html>