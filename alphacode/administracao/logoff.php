<?php
//Verifica se a sess�o do usu�rio foi criada
session_start();
session_destroy();
 
header("Location: index.php");
?>