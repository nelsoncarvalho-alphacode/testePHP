<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Alpha Code Pedidos</title>

		<!-- Importação do BootStrap - CSS e JavaScript -->
		<link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

		<!-- Código para importar o CSS-->
		<link rel="stylesheet" href="../../css_js/css/estilos_sobre_acp/estilo_painel_sobre_acp.css">
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
		<a href="form_cadastro_aluno.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
		<img src="../../img/icones/icones_menu/icone_pedidos.png" width="50px" height="50px"> <br>		
			<b>Pedidos</b></a>	
		<a href="form_consultas_alunos.php" class="btn btn-outline-secondary  id="pos_menu">
		<img src="../../img/icones/icones_menu/icone_produtos.png" width="50px" > <br>	
			<b>Produtos</b></a>
		
		<a href="../../conexao_bd_mysql/teste_conexao_bd_mysql.php" class="btn btn-outline-secondary form_menu" id="pos_menu">
		<img src="../../img/icones/icones_menu/icone_sobre_sacp.png" width="50px" height="50px"> <br>	
			<b>Cliente</b></a>

		<a href="../../validar_usuario.php?sair_sistema=true" 
		target="_parent" class="btn btn-outline-secondary form_menu" id="pos_menu">
		<img src="../../img/icones/icones_menu/icone_sair.png" width="50px" height="50px"> <br>	
			<b>Sair</b></a>
	</nav>

</header>

<div style="position: relative; margin: auto; width: 600px; height: 300px;
border-radius: 20px; padding: 10px; text-align: center;" class="alert alert-secondary">



		<h2 style="text-align: center;">Conheça o ACP</h2> <hr>

<p style="text-align: justify">
	O ACP (Alpha Code Pedidos) foi projetado para testes de pedidos conforme solicitação da empresa AlphaCode. <br>
	O Sistema foi desenvolvido em PHP com MySQL utilizando o BootStrap para formatação das páginas.
</p>

 
   <nav style="margin: 0px; padding: 5px; position: relative; top:-185px; margin-left: -510px;">
        <a href="pg_painel_sobre_acp.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 30px; height: 30px;">
		</a>			
    </nav>

<h6 style="text-align: center">Outubro de 2025</h6>

</div>

</body>
</html>


