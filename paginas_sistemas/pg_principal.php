<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Alpha Code Pedidos</title>

		<!-- Importação do BootStrap - CSS e JavaScript -->
		<link href="../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="../css_js/bootstrap/js/bootstrap.min.js"></script>

		<!-- Código para importar o CSS-->
		<link rel="stylesheet" href="../css_js/css/estilo_principal.css">
</head>
<body>
<header class="alert alert-secondary">
	<h1 style="font-style: italic; text-shadow: 2px -1px 1px rgb(19, 255, 161); text-align: center;  
	font-family: 'Brush Script MT';">ACP<br>Alpha Code Pedidos</h1>
    <hr>
<nav style="text-align: center;"> 

	<a href="pedidos/pg_painel_pedidos.php" class="btn btn-outline-secondary form_menu pos_menu" id="pos_menu">
	<img src="../img/icones/icones_menu/icone_pedidos.png" id="menu_img"> <br>		
		<b>Pedidos</b></a>	
	<a href="produtos/pg_painel_produtos.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
	 <img src="../img/icones/icones_menu/icone_produtos.png" width="50px" height="50px"> <br>	
		<b>Produtos</b></a>
	<a href="clientes/pg_painel_clientes.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
	<img src="../img/icones/icones_menu/icone_clientes.png" width="50p x" height="50px"> <br>	
		<b>Clientes</b></a>
	
	<a href="sobre_acp/pg_painel_sobre_acp.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
	<img src="../img/icones/icones_menu/icone_sobre_sacp.png" width="50px" height="50px"> <br>	
		<b>Sobre o SACP</b></a>

	<a href="../validar_usuario.php?sair_sistema=true" 
	target="_parent" class="btn btn-outline-secondary form_menu" id="pos_menu">
	<img src="../img/icones/icones_menu/icone_sair.png" width="50px" height="50px"> <br>	
		<b>Sair</b></a>
</nav>

</header>

<div style="position: relative; margin: auto; width: 400px; top: 10px;">
	<img src="../img/logotipo_acp.png" style="width: 400px; height: 200px; border-radius: 20px;">
</div>

<footer style="text-align: center; padding: 20px; color:#000000">
	<h4>Versão: 01</h4>
	<h6>Desenvolvido por Ivan Souza</h6>
	<h6>Outubro de 2025</h6>
</footer>

</body>
</html>


