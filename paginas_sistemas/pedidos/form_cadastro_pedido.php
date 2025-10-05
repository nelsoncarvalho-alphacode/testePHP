<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Cadastro de Pedido</title>

<!-- Importação do BootStrap - CSS e JavaScript -->
  <link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" 
  href="../../css_js/css/estilo_pedidos/estilo_form_cadastro_pedidos.css">

</head>
<body>
	
<header>
	<h1 class="alert alert-secondary" role="alert" style="margin: 0px; text-align: center; padding: 13px; top: 10px;">Cadastro de Pedido</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_pedidos.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>			
    </nav>
</header>


<div id="div_form" style="position: relative; top:-50px;">

<fieldset>

<form method="POST" action="salvar_cadastro_pedido_bd.php" enctype="multipart/form-data" >

	<small>Nome do cliente</small> <br>
<input type="text" name="txt_nome_cliente"  placeholder="Nome completo do cliente" autofocus=""
 required style="width: 100%;"> <br>


<small>Código do cliente</small> <br>
<input type="number" name="txt_cod_cliente" min="1">

<div style="position: relative; top: -52px; margin-left: 440px;">
	<small>CPF</small> <br>
	<input type="text" name="txt_cpf" placeholder="000.000.000-00"> <br>
</div>

<div style="position: relative; top: -45px;">
	<small>E-mail</small> <br>
	<input type="text" name="txt_email" placeholder="seuemail@email.com" style="width: 100%;"> <br>

	<small>Data do pedido</small> <br>
	<input type="text" name="txt_data_pedido" id="txt_data_pedido_auto" readonly style="width: 120px;">

	<div style="position: relative; top: -52px; margin-left: 170px;">
	<small>Hora do pedido</small> <br>
	<input type="text" name="txt_hora_pedido"  id="txt_hora_pedido_auto" readonly style="width: 120px;"> <br>
	</div>

<div style="position: relative; top: -50px;">
	<small>Nome do produto</small> <br>
	<input type="text" name="txt_nome_produto"  style="width: 100%;" placeholder="Nome do produto" required>

</div>
<div style="position: relative; top: -50px;">
	<small>Código de barras</small> <br>
	<input type="number" name="txt_cod_barras" value="01/12/2025" min="1">


<div style="position: relative; top: -55px; margin-left: 220px;">
	<small>Valor por unidade</small> <br>
	<input type="number" name="txt_valor_unidade" id="txt_valor_unidade" required value="0" min="0"> <br>
</div>

<div style="position: relative; top: -110px; margin-left: 440px;">
	<small>Quantidade comprada</small> <br>
	<input type="number" name="txt_quant_comprada" id="txt_quant_comprada" required min="1" value="1"> <br>
</div>

</div>


<div style="position: relative; top: -140px;">
	<small>Total</small> <br>
	<input type="text" id="txt_total" disabled value="R$ 0,00" 
	style="text-align: center; font-size: 20px; width: 100%; font-weight: bold;" onclick="cal_pedido()"> <br>
	
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

	
// Cria um objeto Date com a data e hora atuais
const Hora_Data_Atual = new Date();

// Exemplo 1: Usando toLocaleDateString() para uma data formatada localmente
console.log(Hora_Data_Atual.toLocaleDateString()); // Ex: 2/10/2025 (pode variar conforme a localidade)

// Exemplo 2: Extraindo componentes individuais da data"
const dia = Hora_Data_Atual.getDate(); // Dia do mês (1 a 31)
const mes = Hora_Data_Atual.getMonth() + 1; // Mês (0 a 11), então somamos 1
const ano = Hora_Data_Atual.getFullYear(); // Ano (ex: 2025)
const hora = Hora_Data_Atual.getHours();  // Hora
const minuto = Hora_Data_Atual.getMinutes(); // miinuto


document.getElementById("txt_data_pedido_auto").value = String(dia).padStart(2, '0') + "/" + String(mes).padStart(2, '0') + "/" + ano;
	
	document.getElementById("txt_hora_pedido_auto").value = String(hora).padStart(2, '0') + ":" + String(minuto).padStart(2, '0');
</script>

</body>
</html>