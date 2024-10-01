<!DOCTYPE html>
<html lang="pt-BR">
<?php include('../includes/head.php'); ?>
<body>
    <?php include('../includes/header.php'); ?>

    <?php
    // Inclui a conexão com o banco de dados
    include('../config/databae.php'); 

    session_start();

    // Inicializa a conexão com o banco de dados
    $database = new Database();
    $pdo = $database->getConnection();

    // Teste de Conexão
    if (!$pdo) {
        die("Erro: A conexão com o banco de dados não foi estabelecida.");
    }

    // Processa o formulário de cadastro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recupera os dados do formulário
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Senha sem criptografia
        $role = $_POST['role'];

        // Prepara a consulta para inserir os dados na tabela employees
        $stmt = $pdo->prepare("INSERT INTO employees (name, email, password, role) VALUES (:name, :email, :password, :role)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        // Executa a inserção no banco de dados
        if ($stmt->execute()) {
            echo "<script>alert('Funcionário cadastrado com sucesso!');</script>";
            header("Location: login.php"); // Redireciona para a página de login
            exit(); // Certifica-se de que o script seja encerrado após o redirecionamento
        } else {
            echo "<script>alert('Erro ao cadastrar o funcionário.');</script>";
        }
    }
    ?>

    <div class="container mt-5">
        <h2>Cadastrar Funcionário</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Cargo:</label>
                <input type="text" class="form-control" id="role" name="role" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
