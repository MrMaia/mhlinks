<?php
// Inicia a sessão
session_start();

// Desfaz todos os dados da sessão
$_SESSION = array();

// Se está usando cookies de sessão, invalida o cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destrói a sessão
session_destroy();

// Redireciona para a página de login
header("Location: login.php");
exit;