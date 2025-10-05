<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Situação da alteração de cadastro de cliente</title>

	<!-- Importação do BootStrap - CSS e JavaScript -->
	<link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="./.../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../../css_js/css/estilo_produtos/estilo_form_cadastro_produto.css">

</head>
<body>

<?php

include("../../conexao_bd_mysql/conexao_bd_mysql.php");

// Recebendo dados digitados da página alterar_cadastro_aluno_form.php (Via POST)
$codido =  $_POST['txt_codigo']; 
$nome =  $_POST['txt_nome'];
$descricao = $_POST['txt_descricao'];
$modelo = $_POST['txt_modelo'];
$fabricante =  $_POST['txt_fabricante'];
$obs = $_POST['txt_obs'];
$data_fabricacao = $_POST['txt_data_fabricacao'];
$valor_unidade = $_POST['txt_valor_unidade'];
$quant_estoque = $_POST['txt_quant_estoque'];
$data_validade = $_POST['txt_data_validade'];
$endereco_foto = $_POST['txt_end_foto'];


		// mantendo o nome atual da foto
   $novo_nome_img = $endereco_foto;

		//Código para pegar a extensão do arquivo
    $extensao_img = strtolower(substr($_FILES['txt_foto']['name'], -4)); 


if($extensao_img != null)
{

		//Código para pegar a extensão do arquivo
    $extensao_img = strtolower(substr($_FILES['txt_foto']['name'], -4)); 

	  //Código para define o novo nome da foto
 		$novo_nome_img = $nome . "_" . rand(0, 999) . $extensao_img; 


    //define a pasta para onde enviaremos a nova foto
    $diretorio = "../../img/fotos/fotos_produtos/"; 

		// Código para mover a imagem para a pasta escolhida do site
		move_uploaded_file($_FILES['txt_foto']['tmp_name'], $diretorio . $novo_nome_img ); 

/* Código para apagar arquivo de uma pasta
@unlink = Não mostra a mensagem de erro
unlink = Sem o @ mostra a mensagem de erro
prod_nome*/
@unlink($diretorio . $nome_foto_dg);

}


//Script sql para gravar na tabela do banco de dados MySql e MariaDB

$script_sql = "update tb_produto set 
prod_nome = '$nome',
prod_descricao = '$descricao', 
prod_modelo = '$modelo', 
prod_fabricante = '$fabricante',
prod_observacao = '$obs',
prod_data_fabricacao = '$data_fabricacao',
prod_valor_unidade = '$valor_unidade',
prod_quant_estoque = '$quant_estoque',
prod_data_validade = '$data_validade',
prod_foto = '$novo_nome_img'
where prod_codigo = '$codido'; ";


//Comando sql para executar a gravação na tabela do banco de dados MySql e MariaDB

if(mysqli_query($conexao_servidor_bd, $script_sql))
{

	echo "<h1 class='alert alert-secondary' role='alert' style='text-align: center; padding: 50px;'>
	Cadastro de produto alterado com sucesso..</h1>"; 

	 echo"<meta http-equiv='refresh' content='2;url=form_alterar_apagar_cad_produtos.php'> ";

}
else
{
	echo "<div class='alert alert-danger' role='alert' style='text-align: center;' >
	<h1  style='padding: 50px;'>Falha na alteração do cadastro de produto..</h1> 
	<b><h3>Descrição do erro:</b> Houve um erro na gravação de dados na tabela.</h3>
    <h2><a href='form_alterar_apagar_cad_produtos.php' class='btn btn-outline-dark'>Voltar</a></h2> </div>"; 
}

?>
</body>
</html>