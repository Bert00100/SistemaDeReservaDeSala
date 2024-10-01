<?php
// Inclui o arquivo de configuração para conexão com o banco de dados
include('../config/databae.php'); // 

// Inicia a sessão
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Valida os campos
    if (empty($email) || empty($password)) {
        $error = "Todos os campos são obrigatórios!";
    } else {
        try {
            // Inicializa a conexão com o banco de dados
            $database = new Database();
            $conn = $database->getConnection(); // Usa a conexão correta

            // Prepara a consulta SQL usando PDO
            $stmt = $conn->prepare("SELECT * FROM employees WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Verifica se encontrou algum resultado
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verifica se a senha está correta
                if ($password == $user['password']) { // Use password_hash/password_verify se as senhas forem criptografadas
                    // Login bem-sucedido
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];

                    // Redireciona para a página rooms.php
                    header("Location: rooms.php");
                    exit();
                } else {
                    $error = "Senha incorreta!";
                }
            } else {
                $error = "Usuário não encontrado!";
            }
        } catch (PDOException $e) {
            $error = "Erro ao acessar o banco de dados: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include('../includes/head.php'); ?>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center">Login</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Exibe mensagem de erro, se houver -->
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="" method="POST" class="bg-light p-4 border rounded">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <input type="submit" class="btn btn-primary" value="Entrar">
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <a href="register.php">Cadastrar</a> | 
                    <a href="forgot-password.php">Esqueceu a Senha?</a>
                </div>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
