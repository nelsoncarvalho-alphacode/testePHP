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

    <link rel="stylesheet" href="../../css_js/css/estilo_produtos/estilo_form_cadastro_produto_bd.css">

</head>
<body>
    
<?php

include("../../conexao_bd_mysql/conexao_bd_mysql.php");

    //Recebendo dados digitados da página form_cadastro_cliente.php (Via POST)
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


    // Script em SQL para inserir os dados na tabela
    $script_sql_cadastro = 
    "insert into tb_pedido
    (ped_nome_cliente, ped_cod_cliente, ped_cpf, ped_email, ped_data_pedido, ped_hora_pedido, ped_nome_produto, ped_cod_barra,
    ped_valor_unidade, ped_quant_comprada)
    values 
    ('$nome_cliente_dg','$cod_cliente_dg', '$cpf_dg', '$email_dg', '$data_pedido_dg', '$hora_pedido_dg', '$nome_produto_dg', 
    '$cod_barras_dg', '$valor_unidade_dg', '$quant_comprada_dg'); ";


// Executa o cadastro no BD
 if(mysqli_query($conexao_servidor_bd, $script_sql_cadastro))
    {   
        echo "<h1 class='alert alert-secondary' role='alert'
        style='text-align: center; padding: 50px;'>
        Cadastro de pedido realizado com sucesso..</h1>"; 

    // A página fica parada por 3 segundos depois volta para o cadastro de cliente
    echo "<meta http-equiv='refresh' content='2;url=form_cadastro_pedido.php'>";                
    } 
    else
    {
        echo" <div class='alert alert-danger' role='alert'
        style='text-align: center; padding: 50px; color:#fff;'>
		<h1 align='center'>Falha no cadastro de pedido</h1><hr><p>";

        $erro = mysqli_error($conexao_servidor_bd);
        
        echo "<b>Descrição do erro:
        </b> Houve um erro na gravação de dados na tabela com a seguinte descrição: $erro </div>" ;

        // A página fica parada por 10 segundos depois volta para o cadastro de produto
        echo "<meta http-equiv='refresh' content='10;url=form_cadastro_pedido.php'>";
    }  
?>

</body>
</html>