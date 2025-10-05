<!-- Páginda de painel de produtos - Out/2025 -->
 <!-- Desenvolvido por Ivan Souza -->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Alpha Code Pedidos</title>

		<!-- Importação do BootStrap - CSS e JavaScript -->
		<link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

		<!-- Código para importar o CSS-->
		<link rel="stylesheet" href="../../css_js/css/estilos_clientes/estilo_painel_clientes.css">
</head>
<body style=" background-image: 
linear-gradient( to right, rgb(69, 68, 68), rgb(0, 0, 0) 40%, rgb(0, 0, 0), rgb(69, 68, 68) );">
<header class="alert alert-secondary">
	<h1 style="font-style: italic; text-shadow: 2px -1px 1px rgb(19, 255, 161); text-align: center;  
	font-family: 'Brush Script MT';">ACP<br>Alpha Code Pedidos</h1>
    <hr>

	<nav style="text-align: center;"> 

		<a href="../pg_principal.php" class="btn btn-outline-secondary" id="pos_menu">
		<img src="../../img/icones/icones_menu/icone_home.png" width="50px" height="50px"> <br>		
			<b>Home</b></a>	
		<a href="../produtos/pg_painel_produtos.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
		<img src="../../img/icones/icones_menu/icone_pedidos.png" width="50px" height="50px"> <br>		
			<b>Produtos</b></a>	
			
		<a href="../clientes/pg_painel_clientes.php" class="btn btn-outline-secondary  id="pos_menu">
		<img src="../../img/icones/icones_menu/icone_produtos.png" width="50px" > <br>	
			<b>Cliente</b></a>
		
		<a href="../sobre_acp/pg_painel_sobre_acp.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
		<img src="../../img/icones/icones_menu/icone_sobre_sacp.png" width="50px" height="50px"> <br>	
			<b>Sobre o SACP</b></a>

		<a href="../../validar_usuario.php?sair_sistema=true" 
		target="_parent" class="btn btn-outline-secondary form_menu" id="pos_menu">
		<img src="../../img/icones/icones_menu/icone_sair.png" width="50px" height="50px"> <br>	
			<b>Sair</b></a>
	</nav>

</header>

<div style="position: relative; margin: auto; width: 600px; height: 220px;
border-radius: 20px; padding: 10px; text-align: center;" class="alert alert-secondary">

		<h2 style="text-align: center;">Pedidos</h2> <hr>

		<a href="form_cadastro_pedido.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
		<img src="../../img/icones/icones_painel/icone_cadastro.png" width="50px" height="50px"> <br>	
		<b>Cadastro</b></a>

		<a href="form_consultas_pedidos.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
		<img src="../../img/icones/icones_painel/icone_consultas.png" width="50px" height="50px"> <br>	
		<b>Consultas</b></a>

		<a href="form_relatorios_pedidos.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
		<img src="../../img/icones/icones_painel/icone_relatorios.png" width="50px" height="50px"> <br>	
		<b>Relatórios</b></a>
		
		<a href="form_alterar_apagar_cad_pedidos.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
		<img src="../../img/icones/icones_painel/icone_relatorios.png" width="50px" height="50px"> <br>	
		<b>Alterar / Deletar</b></a>
</div>

</body>
</html>


