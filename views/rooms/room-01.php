<?php 
include('../../config/databae.php'); 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$pdo = $database->getConnection();

if (!$pdo) {
    die("Erro: A conexão com o banco de dados não foi estabelecida.");
}

$employee_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hour = $_POST['hour'];
    $date = $_POST['date'];

    // Verifica se já existe uma reserva para a mesma data e horário na tabela room01
    $checkQuery = "SELECT * FROM room01 WHERE date = :date AND hour = :hour";
    $stmt = $pdo->prepare($checkQuery);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':hour', $hour);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Se já houver uma reserva para a mesma data e hora, exibe uma mensagem de erro
        echo "<script>alert('A sala já está reservada para essa data e horário. Escolha outro horário.');</script>";
    } else {
        // Se não houver conflito de horário, insere a nova reserva
        $insertQuery = "INSERT INTO room01 (employee_id, hour, date) VALUES (:employee_id, :hour, :date)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindParam(':hour', $hour);
        $stmt->bindParam(':date', $date);

        if ($stmt->execute()) {
            echo "<script>alert('Reserva registrada com sucesso!');</script>";
            header("Location: ../../index.php");
            exit();
        } else {
            echo "<script>alert('Erro ao registrar a reserva.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include('../../includes/head.php'); ?>
<body>
    <?php include('../../includes/header.php'); ?>
    <main class="container mt-5">
        <h1 class="text-center mb-4">Reservar Sala 01</h1>

        <!-- Exibe as reservas existentes -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Reservas Existentes na Sala 01:</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Funcionário</th>
                            <th>Data</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Exibição das reservas da tabela room01
                        $query = "SELECT e.name, r.hour, r.date 
                                  FROM room01 r
                                  JOIN employees e ON r.employee_id = e.id 
                                  ORDER BY r.date, r.hour";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (count($reservations) > 0) {
                            foreach ($reservations as $row) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['name']) . "</td>
                                        <td>" . date('d/m/Y', strtotime($row['date'])) . "</td>
                                        <td>" . date('H:i', strtotime($row['hour'])) . "</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhuma reserva existente.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Formulário de reserva -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="hour" class="form-label">Hora da Reserva:</label>
                        <input type="time" class="form-control" name="hour" id="hour" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Data da Reserva:</label>
                        <input type="date" class="form-control" name="date" id="date" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Reservar</button>
                </form>
            </div>
        </div>
    </main>
    <?php include('../../includes/footer.php'); ?>
</body>
</html>
