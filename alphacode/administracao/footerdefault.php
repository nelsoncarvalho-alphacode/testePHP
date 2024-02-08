<?php
include("seguranca.php");
?>
<footer class="container" >
  	<p class="float-right"> 		
     <div id="topo">		
	   <a href='#' id='toTop'><img id="btn" class="img-fluid" src="img/voltar.png" alt="Voltar" width="50" height="50"></a>
	 </div>  
	</p>
	<div class="footer">
       <span class="text-muted">Centro de custo: <?php echo $_SESSION["centrodecusto_session"]; ?></span>
    </div>
</footer>	  
