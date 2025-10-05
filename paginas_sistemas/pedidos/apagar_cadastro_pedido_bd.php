<!-- Apagar registro de clientes - Out/2025 -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
      <!-- Código para importar o BootStrap-->
      <link rel="stylesheet" href="../../css_js/bootstrap/css/bootstrap.min.css">
      <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>    

            <link rel="stylesheet" href="../../css_js/css/estilo_pedidos/estilo_form_cadastro_pedidos.css">
</head>
<body>

<?php

include ('../../conexao_bd_mysql/conexao_bd_mysql.php');

if(isset($_POST['txt_cod_selecionado']))
{

$cod_proc_apagar = $_POST['txt_cod_selecionado'];


 
$sql = "DELETE FROM tb_pedido WHERE ped_codigo = '$cod_proc_apagar'";
  
  // Verifica se o comando foi executado com sucesso
  if(mysqli_query($conexao_servidor_bd, $sql))
  	{ 
      echo "<h1 class='alert alert-secondary' role='alert' style='text-align: center; padding: 50px;'>
      Registro de pedido apagadao com sucesso..</h1>"; 
    }
  	else
    {
    echo "<h1 class='alert alert-danger' role='alert' style='text-align: center; padding: 50px;'>
    Registro de pedido não apagado..</h1>";  
    }
    
    echo "<meta http-equiv='refresh' content='2;url=form_alterar_apagar_cad_pedidos.php'>";
}

?>

</body>
</html>
