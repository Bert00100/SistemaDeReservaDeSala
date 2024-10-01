<?php
// Inicia a sessão
session_start();

// Destroi todas as variáveis de sessão
$_SESSION = array(); // Limpa todas as variáveis de sessão

// Se for necessário destruir a sessão, também pode ser feito
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroi a sessão
session_destroy();

// Redireciona para index.php
header("Location: ../index.php");
exit();
?>
