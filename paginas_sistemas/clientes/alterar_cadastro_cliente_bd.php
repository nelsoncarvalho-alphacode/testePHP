<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Situação da alteração de cadastro de cliente</title>

	<!-- Importação do BootStrap - CSS e JavaScript -->
	<link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="./.../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../../css_js/css/estilo_clientes/estilo_form_cadastro_cliente.css">

</head>
<body>

<?php

include("../../conexao_bd_mysql/conexao_bd_mysql.php");

// Recebendo dados digitados da página alterar_cadastro_aluno_form.php (Via POST)
$codigo_dg = $_POST['txt_codigo'];
$nome_foto_dg = $_POST['txt_nome_foto'];

$nome_dg = $_POST['txt_nome'];
$endereco_dg = $_POST['txt_endereco'];
$telefone_dg = $_POST['txt_telefone'];
$celular_dg = $_POST['txt_celular'];
$email_dg = $_POST['txt_email'];
$data_nascimento_dg = $_POST['txt_data_nascimento'];
$rg_dg = $_POST['txt_rg'];
$cpf_dg = $_POST['txt_cpf'];
$data_cadastro_dg = $_POST['txt_data_cadastro'];


		// mantendo o nome atual da foto
   $novo_nome_img = $nome_foto_dg;

		//Código para pegar a extensão do arquivo
    $extensao_img = strtolower(substr($_FILES['txt_foto']['name'], -4)); 


if($extensao_img != null)
{

		//Código para pegar a extensão do arquivo
    $extensao_img = strtolower(substr($_FILES['txt_foto']['name'], -4)); 

	  //Código para define o novo nome da foto
 		$novo_nome_img = $nome_dg . "_" . rand(0, 999) . $extensao_img; 


    //define a pasta para onde enviaremos a nova foto
    $diretorio = "../../img/fotos_clientes/fotos_alunos/"; 

		// Código para mover a imagem para a pasta escolhida do site
		move_uploaded_file($_FILES['txt_foto']['tmp_name'], $diretorio . $novo_nome_img ); 

/* Código para apagar arquivo de uma pasta
@unlink = Não mostra a mensagem de erro
unlink = Sem o @ mostra a mensagem de erro
*/
@unlink($diretorio . $nome_foto_dg);

}


//Script sql para gravar na tabela do banco de dados MySql e MariaDB

$script_sql = "update tb_cliente set 
cli_nome = '$nome_dg',
cli_endereco = '$endereco_dg', 
cli_telefone = '$telefone_dg', 
cli_celular = '$celular_dg',
cli_email = '$email_dg',
cli_data_nascimento = '$data_nascimento_dg',
cli_rg = '$rg_dg',
cli_cpf = '$cpf_dg',
cli_data_cad_cliente = '$data_cadastro_dg',
cli_foto = '$novo_nome_img'
where cli_codigo = '$codigo_dg'; ";


//Comando sql para executar a gravação na tabela do banco de dados MySql e MariaDB

if(mysqli_query($conexao_servidor_bd, $script_sql))
{

	echo "<h1 class='alert alert-secondary' role='alert' style='text-align: center; padding: 50px;'>
	Cadastro de cliente alterado com sucesso..</h1>"; 

	 echo"<meta http-equiv='refresh' content='2;url=form_alterar_apagar_cad_clientes.php'> ";

}
else
{
	echo "<div class='alert alert-danger' role='alert' style='text-align: center;' >
	<h1  style='padding: 50px;'>Falha na alteração do cadastro de aluno..</h1> 
	<b><h3>Descrição do erro:</b> Houve um erro na gravação de dados na tabela.</h3>
    <h2><a href='alterar_cadastro_cliente_form.php' class='btn btn-outline-dark'>Voltar</a></h2> </div>"; 
}

?>
</body>
</html>