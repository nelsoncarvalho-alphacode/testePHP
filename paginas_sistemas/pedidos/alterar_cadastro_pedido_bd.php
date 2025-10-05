<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Situação da alteração de cadastro de Pedido</title>

	<!-- Importação do BootStrap - CSS e JavaScript -->
	<link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="./.../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../../css_js/css/estilo_produtos/estilo_form_cadastro_produto.css">

</head>
<body>

<?php

include("../../conexao_bd_mysql/conexao_bd_mysql.php");

//Recebendo dados Via POST
$codigo_pedido_dg = $_POST['txt_cod_pedido'];

$nome_cliente_dg = $_POST['txt_nome_cliente'];
$cod_cliente_dg = $_POST['txt_cod_cliente'];
$cpf_dg = $_POST['txt_cpf'];
$email_dg = $_POST['txt_email'];
$data_pedido_dg = $_POST['txt_data_pedido'];
$hora_pedido_dg = $_POST['txt_hora_pedido'];
$nome_produto_dg = $_POST['txt_nome_produto'];
$cod_barras_dg = $_POST['txt_cod_barras'];
$valor_unidade_dg = $_POST['txt_valor_unidade'];
$quant_comprada_dg = $_POST['txt_quant_comprada'];


//Script sql para altualizar na tabela do banco de dados MySql e MariaDB

$script_sql = "update tb_pedido set 
ped_nome_cliente = '$nome_cliente_dg',
ped_cod_cliente = '$cod_cliente_dg', 
ped_cpf = '$cpf_dg', 
ped_email = '$email_dg',
ped_data_pedido = '$data_pedido_dg',
ped_hora_pedido = '$hora_pedido_dg',
ped_nome_produto = '$nome_produto_dg',
ped_cod_barra = '$cod_barras_dg',
ped_valor_unidade = '$valor_unidade_dg',
ped_quant_comprada = '$quant_comprada_dg'
where ped_codigo  = '$codigo_pedido_dg'; ";


//Comando sql para executar a gravação na tabela do banco de dados MySql e MariaDB

if(mysqli_query($conexao_servidor_bd, $script_sql))
{
	echo "<h1 class='alert alert-secondary' role='alert' style='text-align: center; padding: 50px;'>
	Cadastro de pedido alterado com sucesso..</h1>"; 

	 echo"<meta http-equiv='refresh' content='2;url=form_alterar_apagar_cad_pedidos.php'> ";
}
else
{
	echo "<div class='alert alert-danger' role='alert' style='text-align: center;' >
	<h1  style='padding: 50px;'>Falha na alteração do cadastro de pedido..</h1> 
	<b><h3>Descrição do erro:</b> Houve um erro na gravação de dados na tabela.</h3>
    <h2><a href='form_alterar_apagar_cad_pedidos.php' class='btn btn-outline-dark'>Voltar</a></h2> </div>"; 
}

?>
</body>
</html>