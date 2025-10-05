<!-- Páginda de Formulário de cadastro de produtos - Out/2025 -->
 <!-- Desenvolvido por Ivan Souza -->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Cadastro de Produto</title>

<!-- Importação do BootStrap - CSS e JavaScript -->
  <link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" 
  href="../../css_js/css/estilo_produtos/estilo_form_cadastro_produto.css">

</head>
<body>
	
<header>
	<h1 class="alert alert-secondary" role="alert" 
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">Cadastro de Produto
	</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_produtos.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>			
    </nav>
</header>


<div id="div_form" style="position: relative; top:-50px;">

<fieldset style="height: 380px;">

<form method="POST" action="salvar_cadastro_produto_bd.php" style="width: 650px; padding: 20px;" enctype="multipart/form-data">

		<small>Nome do produto</small> <br>
	<input type="text" name="txt_nome_produto"  placeholder="Nome completo do produto" autofocus=""
	required style="width: 100%;"> <br>
		<small>Descrição do produto</small> <br>
	<input type="text" name="txt_descricao" placeholder="Descrição aqui.." style="width: 100%;"> <br>
		<small>Modelo</small> <br>
	<input type="text" name="txt_modelo" placeholder="Modelo aqui...">

	<div style="position: relative; top: -50px; margin-left: 420px;">
		<small>Fabricante</small> <br>
		<input type="text" name="txt_fabricante" placeholder="Nome do fabricante"> <br>
	</div>

	<div style="position: relative; top: -45px;">
		<small>Observação</small> <br>
	<input type="text" name="txt_obs" placeholder="Observação sobre o produto" style="width: 100%;"> <br>

		<small>Data de fabricação</small> <br>
	<input type="date" name="txt_data_fabricacao">

	<div style="position: relative; top: -55px; margin-left: 190px;">
		<small>Valor por unidade</small> <br>
		<input type="number" name="txt_valor_unidade"> <br>
	</div>

	<div style="position: relative; top: -110px; margin-left: 420px;">
		<small>Quantidade em estoque</small> <br>
		<input type="number" name="txt_quant_estoque"> <br>
	</div>
	</div>

	<div style="position: relative; top: -145px;">
		<small>Data de validade</small> <br>
	<input type="date" name="txt_data_validade">
	</div>
	</fieldset>

	<fieldset style="text-align: center;">
		<label for="txt_foto">Escolha a foto do produto:</label>

		<input type="file" name="txt_foto_produto" accept="image/png, image/gif, image/jpeg" 
		id="txt_foto_selecionada">
		<hr>

		<img src="../../img/foto_padrao.png" id="img_selecionada" 
		style="width: 200px; height: 220px; border: solid 2px; border-radius: 100%;">
	</fieldset>

	<fieldset style="text-align: center;">
		<input type="submit" name="btn_salvar" value="Salvar" class="btn btn-outline-success">
		<input type="reset" name="btn_limpar" value="limpar" class="btn btn-outline-warning"
		onclick="javascript:limpar_foto();">
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

	 function limpar_foto()
	 {document.getElementById("img_selecionada").src = "../../img/foto_padrao.png";}
</script>

</body>
</html>