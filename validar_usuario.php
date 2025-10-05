<!-- Páginda desenvolvida para o teste da ALPHACODE - Out/2025 -->
 <!-- Desenvolvida por Ivan Souza -->
  
<?php

if($_POST)
{
    $usuario = strtoupper($_POST['txt_usuario']);
    $senha = strtoupper($_POST['txt_senha']);

    $situacao_usuario = false;

        // Validando usuários do sistema
        if($usuario == "ADM" and $senha == "123")
        { $situacao_usuario = true; }
            else
        if($usuario == "GERENTE" and $senha == "200")
        { $situacao_usuario = true; }
            else
        if($usuario == "FUNC" and $senha == "2000")
        { $situacao_usuario = true; }
            else
        {
            limpar_cookies(); 
            header("Location:index.php?erro_login=true");        
        }


    // Abrindo página inicial do sistema após a validação
    if($situacao_usuario == true)
    {
        // Inicia a sessão do PHP
        session_start();
        $_SESSION['usuario_validado'] = true;

        header("Location:pg_site.php");
    }

}


// O código abaixo será executado quando clicar no botão SAIR
if($_GET)
{
   $sair = $_GET['sair_sistema'];

    if($sair == true)
    {
       limpar_cookies();    
        header("Location:index.php");
    }

}


    function limpar_cookies()
    {
        session_destroy();

        /*Código para apagar todos os cookies do site no intervalo de 3600 sgundos para trás
        a barra define o caminho da URL  /  */
        foreach ($_COOKIE as $todos_cookies => $null) 
        { setcookie($todos_cookies, '', time() - 3600, '/');  }  

    }


 
?>

