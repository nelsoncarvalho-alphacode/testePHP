<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->
  
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ACP - Alpha Code Pedidos</title>

    <!-- Código para inserir o icone na página-->
    <link rel="icon" href="img/icones/icones_acp/icone_acp.png" type="image/png">

    <!-- Código para importar o BootStrap-->
     <link rel="stylesheet" href="css_js/bootstrap/css/bootstrap.min.css">
     <script src="css_js/bootstrap/js/bootstrap.min.js"></script>
  
     <!-- Código para importar o CSS-->
     <link rel="stylesheet" href="css_js/css/estilo_index.css">
</head>
<body>
<header>
	<div id="div_topo">
        <img src="img/logotipo_acp.png"  id="img_logotipo">
    </div> 
</header>
  

<form method="post" id="form_login" action="validar_usuario.php" class="btn btn-dark"">
    <small>Usuário</small><br>
    <input type="text" name="txt_usuario" autofocus="" required="" autocomplete="off" class="form-control" id="format_input"> <br>
    <small>Senha</small><br>
    <input type="password" name="txt_senha" autocomplete="off" class="form-control" id="format_input"> 
    <br>
    <input type="submit" value="Entrar" class="btn btn-outline-light" id="formato_botao">


    <small id="txt_status_login" class="alert alert-danger" role="alert" 
    style="display: none; width: 90%; position: relative; margin: auto; top: 20px; ">
    </small>
</form>

	


    <?php
    if($_GET)
    {
    echo"
    <script> 
        document.getElementById('txt_status_login').innerHTML = 'Erro na validação do usuário';			
        document.getElementById('txt_status_login').style.display = 'block';
        document.getElementById('form_login').style.border = 'solid 5px';
        document.getElementById('form_login').style.borderColor = 'red';
    </script>";
    }
    ?>

    <script>
        window.setInterval(function()
        { document.getElementById("txt_status_login").style.display = "none";
        document.getElementById('form_login').style.border = 'none';
        }, 2000);
    </script>

</body>
</html>