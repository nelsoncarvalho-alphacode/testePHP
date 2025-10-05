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
    $nome_produto_dg = $_POST['txt_nome_produto'];
    $descricao_dg = $_POST['txt_descricao'];
    $modelo_dg = $_POST['txt_modelo'];
    $fabricante_dg = $_POST['txt_fabricante'];
    $obs_dg = $_POST['txt_obs'];
    $data_fabricacao_dg = $_POST['txt_data_fabricacao'];
    $valor_unidade_dg = $_POST['txt_valor_unidade'];
    $quant_estoque_dg = $_POST['txt_quant_estoque'];
    $data_validade_dg = $_POST['txt_data_validade'];

// Captura a extensão do arquivo da foto
$extensao_foto = substr($_FILES['txt_foto_produto']['name'], -4);
 

if($extensao_foto != "")
{
    //Captura a extensão da foto
    $extensao_foto = strtolower(substr($_FILES['txt_foto_produto']['name'], -4));

    /* Código para define um número aleatório para a foto
     (Função RAND do PHP: Gera um número randômico) */
    $novo_nome_img = $nome_dg . "_" . rand(0, 999) . $extensao_foto; 
 
    //Local do diretório de todas as fotos dos produtos
    $diretorio = "../../img/fotos/fotos_produtos/"; 

    // Código para mover a foto para o novo dirtório
    move_uploaded_file($_FILES['txt_foto_produto']['tmp_name'], $diretorio . $novo_nome_img ); 
}
else
{ $novo_nome_img = "foto_padrao.png"; }


    // Script em SQL para inserir os dados na tabela
    $script_sql_cadastro = 
    "insert into tb_produto 
    (prod_nome, prod_descricao, prod_modelo, prod_fabricante, prod_observacao, prod_data_fabricacao, prod_valor_unidade, prod_quant_estoque, prod_data_validade,  prod_foto)
    values 
    ('$nome_produto_dg','$descricao_dg', '$modelo_dg', '$fabricante_dg', '$obs_dg', 
    '$data_fabricacao_dg', '$valor_unidade_dg', '$quant_estoque_dg', '$data_validade_dg', '$novo_nome_img'); ";


// Executa o cadastro no BD
 if(mysqli_query($conexao_servidor_bd, $script_sql_cadastro))
    {   
        echo "<h1 class='alert alert-secondary' role='alert'
        style='text-align: center; padding: 50px;'>
        Cadastro de produto realizado com sucesso..</h1>"; 

        // A página fica parada por 3 segundos depois volta para o cadastro de cliente
        echo "<meta http-equiv='refresh' content='2;url=form_cadastro_produto.php'>";                
    } 
    else
    {
        echo" <div class='alert alert-danger' role='alert'
        style='text-align: center; padding: 50px; color:#fff;'>
		<h1 align='center'>Falha no cadastro de cliente</h1><hr><p>";

        $erro = mysqli_error($conexao_servidor_bd);
        
        echo "<b>Descrição do erro:
        </b> Houve um erro na gravação de dados na tabela com a seguinte descrição: $erro </div>" ;

        // A página fica parada por 10 segundos depois volta para o cadastro de produto
        echo "<meta http-equiv='refresh' content='10;url=form_cadastro_produto.php'>";
    }  
 
?>

</body>
</html>