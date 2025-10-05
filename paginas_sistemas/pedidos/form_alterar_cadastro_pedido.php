<!-- Páginda de Formulário de cadastro de produtos - Out/2025 -->
 <!-- Desenvolvido por Ivan Souza -->

 <?php
					
	//Recebendo dados Via POST
	$codigo_pedido_dg = $_POST['txt_cod_selecionado'];

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
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Alteração de cadastro de Pedido</title>

	<!-- Importação do BootStrap - CSS e JavaScript -->
	<link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" 
	href="../../css_js/css/estilo_pedidos/estilo_form_cadastro_pedidos.css">
</head>
<body>
	
<header>
	<h1 class="alert alert-secondary" role="alert" style="margin: 0px; text-align: center; padding: 13px; top: 10px;">
		Formulário de Alteração de Cadastro de Pedido
	</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_pedidos.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>			
    </nav>
</header>


<div id="div_form" style="position: relative; top:-50px;">

<fieldset>

<form method="POST" action="alterar_cadastro_pedido_bd.php" enctype="multipart/form-data">

<input type="hidden" name="txt_cod_pedido" value="<?php echo $codigo_pedido_dg; ?>">

	<small>Nome do cliente</small> <br>
<input type="text" name="txt_nome_cliente" autofocus="" value="<?php echo $nome_cliente_dg; ?>"
 required style="width: 100%;"> <br>


<small>Código do cliente</small> <br>
<input type="number" name="txt_cod_cliente" min="0" value="<?php echo $cod_cliente_dg; ?>">

<div style="position: relative; top: -50px; margin-left: 440px;">
	<small>CPF</small> <br>
	<input type="text" name="txt_cpf" value="<?php echo $cpf_dg; ?>" > <br>
</div>

<div style="position: relative; top: -45px;">
	<small>E-mail</small> <br>
	<input type="text" name="txt_email" value="<?php echo $email_dg; ?>" style="width: 100%;"> <br>

	<small>Data do pedido</small> <br>
	<input type="text" name="txt_data_pedido" value="<?php echo $data_pedido_dg; ?>" readonly style="width: 120px;">


	<div style="position: relative; top: -52px; margin-left: 170px;">
	<small>Hora do pedido</small> <br>
	<input type="text" name="txt_hora_pedido" value="<?php echo $hora_pedido_dg; ?>" readonly style="width: 120px;"> <br>
</div>

<div style="position: relative; top: -50px;">
	<small>Nome do produto</small> <br>
	<input type="text" name="txt_nome_produto"  style="width: 100%;" value="<?php echo $nome_produto_dg; ?>" required>
</div>

<div style="position: relative; top: -50px;">
	<small>Código de barras</small> <br>
	<input type="number" name="txt_cod_barras" min="0" value="<?php echo $cod_barras_dg; ?>">


<div style="position: relative; top: -55px; margin-left: 220px;">
	<small>Valor por unidade</small> <br>
	<input type="number" name="txt_valor_unidade" id="txt_valor_unidade" required value="<?php echo $valor_unidade_dg; ?>"> <br>
</div>

<div style="position: relative; top: -110px; margin-left: 440px;">
	<small>Quantidade comprada</small> <br>
	<input type="number" name="txt_quant_comprada" id="txt_quant_comprada" required min="1" value="1" value="<?php echo $quant_comprada_dg; ?>"> <br>
</div>

</div>


<div style="position: relative; top: -140px;">
	<small>Total</small> <br>
	<input type="text" id="txt_total" disabled value="R$ 0,00" 
	style="text-align: center; font-size: 20px; width: 100%; font-weight: bold;"> <br>

	<input type="submit" name="btn_salvar" value="Salvar" class="btn btn-outline-success" 
	style="width: 100%; top: 20px; position: relative;" >
</div>

</fieldset>


</form>
</div>

<script>

	function cal_pedido()
	{

		var val_unidade = document.getElementById("txt_valor_unidade").value;
		var quantidade = document.getElementById("txt_quant_comprada").value;

		var total = parseFloat(val_unidade) * parseFloat(quantidade);	

		 const formatadorMoeda = new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL', });

		document.getElementById("txt_total").value = formatadorMoeda.format(total);

	}

	window.setInterval(function()
	{  cal_pedido();  }, 500);

</script>

</body>
</html>