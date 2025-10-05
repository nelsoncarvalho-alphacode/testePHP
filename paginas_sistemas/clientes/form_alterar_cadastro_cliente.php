<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->

<?php
			       
$codido =  $_POST['txt_cod_selecionado']; 
$nome =  $_POST['txt_nome'];
$endereco = $_POST['txt_endereco'];
$telefone = $_POST['txt_telefone'];
$celular =  $_POST['txt_celular'];
$email = $_POST['txt_email'];
$data_nascimento = $_POST['txt_data_nascimento'];
$rg = $_POST['txt_rg'];
$cpf = $_POST['txt_cpf'];
$data_cadastro = $_POST['txt_data_cadastro'];
$endereco_foto = $_POST['txt_end_foto'];

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SRA - Alteração de cadastro de Aluno</title>

<!-- Importação do BootStrap - CSS e JavaScript -->
<link href="../../css_js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../css_js/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="../../css_js/css/estilo_clientes/estilo_form_cadastro_cliente.css">

</head>
<body>

<header>
	<h1 class="alert alert-secondary" role="alert" 
		style="margin: 0px; text-align: center; padding: 13px; top: 10px;">
		Formulário de Alteração de Cadastro de cliente
	</h1>

    <nav style="margin: 0px; padding: 5px; position: relative; top:-60px;">
        <a href="form_alterar_apagar_cad_clientes.php"  class="btn btn-outline-secondary" title="Voltar">
			<img src="../../img/icones/icones_acp/voltar.png" style="width: 40px; height: 40px;">
		</a>			
    </nav>
</header>


<div id="div_form">

<fieldset style="height: 380px;">


<form method="POST" action="alterar_cadastro_cliente_bd.php" style="width: 650px; padding: 20px;" enctype="multipart/form-data">

<input type="hidden" name="txt_codigo" value="<?php echo $codigo; ?>">
<input type="hidden" name="txt_nome_foto" value="<?php echo $endereco_foto; ?>">


	<small>Nome</small> <br> 
<input type="text" name="txt_nome" autofocus="" required style="width: 100%;"
value="<?php echo "$nome"; ?>">
 <br>

	<small>Endereço</small> <br>
<input type="text" name="txt_endereco" style="width: 100%;" value="<?php echo $endereco; ?>"> <br>

	<small>Telefone</small> <br>
<input type="text" name="txt_telefone" value="<?php echo $telefone; ?>">


<div style="position: relative; top: -50px; margin-left: 420px;">

	<small>Celular</small> <br>
	<input type="text" name="txt_celular" value="<?php echo $celular; ?>"> <br>
</div>

<div style="position: relative; top: -45px;">
	<small>E-mail</small> <br>
<input type="text" name="txt_email" style="width: 100%;" value="<?php echo $email; ?>"> <br>

	<small>Data de nascimento</small> <br>
<input type="date" name="txt_data_nascimento" value="<?php echo $data_nascimento; ?>">

<div style="position: relative; top: -50px; margin-left: 190px;">
	<small>RG</small> <br>
	<input type="text" name="txt_rg" value="<?php echo $rg; ?>"> <br>
</div>

<div style="position: relative; top: -100px; margin-left: 420px;">
	<small>CPF</small> <br>
	<input type="text" name="txt_cpf" value="<?php echo $cpf; ?>" > <br>
</div>

</div>

<div style="position: relative; top: -145px;">
	<small>Data do cadastro</small> <br>
<input type="date" name="txt_data_cadastro" value="<?php echo $data_cadastro; ?>">

</div>
</fieldset> 

<fieldset style="text-align: center;">
	<small>Escolha a foto:</small>

	<input type="file" name="txt_foto" accept="image/png, image/gif, image/jpeg" 
	id="txt_foto_selecionada">
	<hr>

	 <img src="../img/fotos/fotos_clientes/<?php echo $endereco_foto ?>" id="img_selecionada" alt="Sem foto"
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