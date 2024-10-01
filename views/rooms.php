<?php
// Inclui o arquivo de configuração para conexão com o banco de dados
include('../config/databae.php');

// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Redireciona para a página de login se não estiver logado
    header("Location: login.php");
    exit();
}

// Pega o nome do usuário da sessão
$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include('../includes/head.php'); ?>
<body>
    <?php include('../includes/header.php'); ?>
    <main class="container mt-5">
        <h2 class="text-center mb-4">Bem-vindo, <?php echo htmlspecialchars($user_name); ?>!</h2>
        <h1 class="text-center mb-4">Salas para Reserva</h1>
        <ul class="list-unstyled row text-center">
            <li class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Sala 01</h2>
                        <h3 class="card-subtitle mb-2 text-muted">Sala de Reunião 01</h3>
                        <p class="card-text">Sala de reunião para 4 pessoas.</p>
                        <a href="rooms/room-01.php" class="btn btn-primary">Reservar</a>
                    </div>
                </div>
            </li>
            <li class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Sala 02</h2>
                        <h3 class="card-subtitle mb-2 text-muted">Sala de Reunião 02</h3>
                        <p class="card-text">Sala de reunião para 6 pessoas.</p>
                        <a href="rooms/room-02.php" class="btn btn-primary">Reservar</a>
                    </div>
                </div>
            </li>
        </ul>
    </main>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
