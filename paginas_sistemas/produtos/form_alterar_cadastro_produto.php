<?php
			       
$codigo =  $_POST['txt_cod_selecionado']; 
$nome =  $_POST['txt_nome'];
$descricao = $_POST['txt_descricao'];
$modelo = $_POST['txt_modelo'];
$fabricante =  $_POST['txt_fabricante'];
$obs = $_POST['txt_obs'];
$data_fabricacao = $_POST['txt_data_fabricacao'];
$tamanho = $_POST['txt_tamanho'];
$num_registro = $_POST['txt_num_registro'];
$data_validade = $_POST['txt_data_validade'];
$endereco_foto = $_POST['txt_end_foto'];

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Alteração de cadastro de produtos</title>

<!-- Importação do BootStrap - CSS e JavaScript -->
<link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="../../css_js/css/estilo_clientes/estilo_form_cadastro_cliente.css">

</head>
<body>

<header>
	<h1 class="alert alert-secondary" role="alert" 
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">
		Formulário de Alteração de Cadastro de Produto
	</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="form_alterar_apagar_cad_produtos.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>			
    </nav>
</header>


<div id="div_form">

<fieldset style="height: 380px;">


<form method="POST" action="alterar_cadastro_produto_bd.php" style="width: 650px; padding: 20px;" enctype="multipart/form-data">

<input type="hidden" name="txt_codigo" value="<?php echo $codigo; ?>">
<input type="hidden" name="txt_end_foto" value="<?php echo $endereco_foto; ?>">


	<small>Nome</small> <br> 
<input type="text" name="txt_nome" autofocus="" required style="width: 100%;" value="<?php echo "$nome"; ?>">
 <br>

	<small>Descrição do produto</small> <br>
<input type="text" name="txt_descricao" style="width: 100%;" value="<?php echo $descricao; ?>"> <br>

	<small>Modelo</small> <br>
<input type="text" name="txt_modelo" value="<?php echo $modelo; ?>">


<div style="position: relative; top: -50px; margin-left: 420px;">
	<small>Fabricante</small> <br>
	<input type="text" name="txt_fabricante" value="<?php echo $fabricante; ?>"> <br>
</div>

<div style="position: relative; top: -45px;">
	<small>E-Observação</small> <br>
<input type="text" name="txt_obs" style="width: 100%;" value="<?php echo $obs; ?>"> <br>

	<small>Data de fabricação</small> <br>
<input type="date" name="txt_data_fabricacao" value="<?php echo $data_fabricacao; ?>">

<div style="position: relative; top: -50px; margin-left: 200px;">
	<small>Valor por unidade</small> <br>
	<input type="text" name="txt_valor_unidade" value="<?php echo $tamanho; ?>"> <br>
</div>

<div style="position: relative; top: -100px; margin-left: 420px;">
	<small>Quatodade em estoque</small> <br>
	<input type="text" name="txt_quant_estoque" value="<?php echo $num_registro; ?>" > <br>
</div>

</div>

<div style="position: relative; top: -145px;">
	<small>Data de validade</small> <br>
<input type="date" name="txt_data_validade" value="<?php echo $data_validade; ?>">

</div>
</fieldset> 

<fieldset style="text-align: center;">
	<small>Escolha a foto do produto:</small>

	<input type="file" name="txt_foto" accept="image/png, image/gif, image/jpeg" 
	id="txt_foto_selecionada">
	<hr>

	 <img src="../../img/fotos/fotos_produtos/<?php echo $endereco_foto ?>" id="img_selecionada" alt="Sem foto"
	 style="width: 200px; height: 220px; border: solid 2px; border-radius: 100%;">

</fieldset>

<fieldset style="text-align: center;">

			<input type="submit" name="btn_salvar" value="Salvar alteração" class="btn btn-success">
			
</fieldset>
</form>

</div>


<script type="text/javascript">
	
	 function Trocar_Foto()
	 {
			var novo_arquivo = new FileReader();
			novo_arquivo.onload = function(e){document.getElementById("img_selecionada").src = e.target.result; 
		};
			novo_arquivo.readAsDataURL(this.files[0]);
	 }
	 
	 document.getElementById("txt_foto_selecionada").addEventListener("change", Trocar_Foto, false);



</script>

</body>
</html>