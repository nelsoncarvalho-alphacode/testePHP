<?php
/**
 * Logout - Encerrar session do user
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario_nome = $_SESSION['usuario_nome'] ?? 'Usuário';

$_SESSION = [];

if (isset($_COOKIE[session_name()])) {
    setcookie(
        session_name(),
        '',
        time() - 3600,
        '/',
        '',
        isset($_SERVER['HTTPS']),
        true
    );
}

session_destroy();

session_start();
$_SESSION['sucesso'] = 'Logout realizado com sucesso! Até logo, ' . htmlspecialchars($usuario_nome) . '!';

header('Location: views/login.php');
exit;