<?php
include("seguranca.php");
?>
<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light" role="navigation">
        
		<a class="navbar-brand" href="#">Gestor</a>
		
		 <div class="col text-left nowrap">
		  Usuário: <?php echo $_SESSION["login_session"]; ?> 
		  </div>
		     
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Menu">
          <span class="navbar-toggler-icon"></span>
         </button>

		  <div class="collapse navbar-collapse navbar-right" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
			  <li class="nav-item active">
				<a class="nav-link" href="administracao.php">Home</a>		
			  </li>
              
				

              <?php if($_SESSION["usuarios_session"]=="1" 
			         || $_SESSION["alterarsenha_session"]=="1"
					 || $_SESSION["solucoes_session"]=="1"
					 || $_SESSION["nivelacesso_session"]=="1"
					 || $_SESSION["centrodecusto_session"]=="1"
					 || $_SESSION["relatoriousuarios_session"]=="1"){ ?>			  
			  <li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Controle de acesso
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <?php if($_SESSION["usuarios_session"]=="1"){ ?>
				  <a class="dropdown-item" href="candidatolista.php">Candidatos</a>
				  <?php } ?>
                  <?php if($_SESSION["usuarios_session"]=="1"){ ?>
				  <a class="dropdown-item" href="usuariolista.php">Usuários</a>
				  <?php } ?>
				  <?php if($_SESSION["alterarsenha_session"]=="1"){ ?>
				  <a class="dropdown-item" href="usuarioalterarsenha.php">Alterar senha</a>
				  <?php } ?>
				  <?php if($_SESSION["nivelacesso_session"]=="1"){ ?>
				  <a class="dropdown-item" href="nivelacessolista.php">Níveis de acesso</a>
                  <?php } ?>
				  <?php if($_SESSION["centro_session"]=="1"){ ?>
                  <a class="dropdown-item" href="centrodecustolista.php">Centro de custo</a>
				  <?php } ?>
				  <?php if($_SESSION["relatoriousuarios_session"]=="1"){ ?>
                  <a class="dropdown-item" href="relatoriousuariospesquisa.php">Relatório de usuários</a>
				  <?php } ?>
				</div>
			  </li>
              <?php } ?>              
			  <li class="nav-item">
				<a class="nav-link" href="logoff.php">Sair</a>
			  </li> 
			</ul>
        </div>
</nav>
