<?php
//Verifica se a sessão do usuário foi criada
session_start();
session_destroy();
 
header("Location: index.php");
?>