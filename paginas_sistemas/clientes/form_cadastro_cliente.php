<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ACP - Cadastro de Cliente</title>

<!-- Importação do BootStrap - CSS e JavaScript -->
  <link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" 
  href="../../css_js/css/estilo_clientes/estilo_form_cadastro_cliente.css">

</head>
<body>
	
<header>
	<h1 class="alert alert-secondary" role="alert" 
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">Cadastro de Cliente
	</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="pg_painel_clientes.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>			
    </nav>
</header>


<div id="div_form" style="position: relative; top:-50px;">

<fieldset style="height: 380px;">

<form method="POST" action="salvar_cadastro_cliente_bd.php" style="width: 650px; padding: 20px;" enctype="multipart/form-data">

	<small>Nome</small> <br>
<input type="text" name="txt_nome"  placeholder="Nome completo" autofocus=""
 required style="width: 100%;"> <br>
	<small>Endereço</small> <br>
<input type="text" name="txt_endereco" placeholder="Rua / Av: Tal, 000" style="width: 100%;"> <br>
	<small>Telefone</small> <br>
<input type="text" name="txt_telefone" placeholder="Telefone Ex:(00) 0000-0000">

<div style="position: relative; top: -50px; margin-left: 420px;">
	<small>Celular</small> <br>
	<input type="text" name="txt_celular" placeholder="Celular Ex:(00) 00000-0000"> <br>
</div>

<div style="position: relative; top: -45px;">
	<small>E-mail</small> <br>
<input type="text" name="txt_email" placeholder="emailteste@gmail.com" style="width: 100%;"> <br>

	<small>Data de nascimento</small> <br>
<input type="date" name="txt_data_nascimento">

<div style="position: relative; top: -50px; margin-left: 190px;">
	<small>RG</small> <br>
	<input type="text" name="txt_rg" placeholder="00000000-0"> <br>
</div>

<div style="position: relative; top: -105px; margin-left: 420px;">
	<small>CPF</small> <br>
	<input type="text" name="txt_cpf" placeholder="000.000.000-00"> <br>
</div>
</div>

<div style="position: relative; top: -145px;">
	<small>Data do cadastro</small> <br>
<input type="date" name="txt_cod_data_cad_cliente">
</div>
</fieldset>

<fieldset style="text-align: center;">
	<label for="txt_foto">Escolha a foto:</label>

	<input type="file" name="txt_foto" accept="image/png, image/gif, image/jpeg" 
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