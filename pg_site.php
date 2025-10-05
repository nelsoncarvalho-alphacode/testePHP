<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->
  
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ACP - Alpha Code Pedidos</title>
        <!-- Código para inserir o icone na página-->
    <link rel="icon" href="img/icones/icones_acp/icone_acp.png" type="image/png">

    <link rel="stylesheet" href="css_js/css/estilo_pg_site.css">
    
</head>
<body >

<?php
        // Iniciar a sessão do PHP
        session_start();

    if($_SESSION['usuario_validado'] == true)
        { include("carregar_pagina.php"); }
        else
        {	
            header("Location:index.php?erro_login=true"); 
            session_destroy();
        }
    ?>

</body>
</html>



