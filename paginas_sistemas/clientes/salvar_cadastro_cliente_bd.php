<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <!-- Código para importar o BootStrap-->
    <link rel="stylesheet" href="../../css_js/bootstrap/css/bootstrap.min.css">
     <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>    

       <link rel="stylesheet" href="../../css_js/css/estilo_clientes/estilo_form_cadastro_cliente_bd.css">

</head>
<body>

<?php

include("../../conexao_bd_mysql/conexao_bd_mysql.php");

//Recebendo dados digitados da página form_cadastro_cliente.php (Via POST)
$nome_dg = $_POST['txt_nome'];
$endereco_dg = $_POST['txt_endereco'];
$telefone_dg = $_POST['txt_telefone'];
$celular_dg = $_POST['txt_celular'];
$email_dg = $_POST['txt_email'];
$data_nascimento_dg = $_POST['txt_data_nascimento'];
$rg_dg = $_POST['txt_rg'];
$cpf_dg = $_POST['txt_cpf'];
$cod_data_cad_cliente_dg = $_POST['txt_cod_data_cad_cliente'];

// Captura a extensão do arquivo da foto
$extensao_foto = substr($_FILES['txt_foto']['name'], -4);
 

if($extensao_foto != "")
{
    //Captura a extensão da foto
    $extensao_foto = strtolower(substr($_FILES['txt_foto']['name'], -4));

    /* Código para define um número aleatório para a foto
     (Função RAND do PHP: Gera um número randômico) */
    $novo_nome_img = $nome_dg . "_" . rand(0, 999) . $extensao_foto; 
 
    //Local do diretório de todas as fotos dos clientes
    $diretorio = "../../img/fotos/fotos_clientes/"; 

    // Código para mover a foto para o novo dirtório
    move_uploaded_file($_FILES['txt_foto']['tmp_name'], $diretorio . $novo_nome_img ); 
}
else
{ $novo_nome_img = "foto_padrao.png"; }


    // Script em SQL para inserir os dados na tabela
    $script_sql_cadastrar_cliente = 
    "insert into tb_cliente (cli_nome, cli_endereco, cli_telefone, cli_celular, cli_email, cli_data_nascimento, cli_rg, cli_cpf, cli_data_cad_cliente, cli_foto)
    values 
    ('$nome_dg','$endereco_dg', '$telefone_dg', '$celular_dg', '$email_dg', 
    '$data_nascimento_dg', '$rg_dg', '$cpf_dg', '$cod_data_cad_cliente_dg', '$novo_nome_img'); ";



// Executa o cadastro no BD
 if(mysqli_query($conexao_servidor_bd, $script_sql_cadastrar_cliente))
    {   
        echo "<h1 class='alert alert-secondary' role='alert'
        style='text-align: center; padding: 50px;'>
        Cadastro de cliente realizado com sucesso..</h1>"; 

    // A página fica parada por 3 segundos depois volta para o cadastro de cliente
    echo "<meta http-equiv='refresh' content='3;url=form_cadastro_cliente.php'>";                
    } 
    else
    {
        echo" <div class='alert alert-danger' role='alert'
        style='text-align: center; padding: 50px; color:#fff;'>
		<h1 align='center'>Falha no cadastro de cliente</h1><hr><p>";

        $erro = mysqli_error($conexao_servidor_bd);
        
        echo "<b>Descrição do erro:
        </b> Houve um erro na gravação de dados na tabela com a seguinte descrição: $erro </div>" ;

        // A página fica parada por 10 segundos depois volta para o cadastro de cliente
        echo "<meta http-equiv='refresh' content='10;url=form_cadastro_clientephp'>";
    }  
?>

</body>
</html>