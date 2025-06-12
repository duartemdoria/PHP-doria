<?php
include("conexoes/conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Fetch all consultations for the logged-in user
$sql = "SELECT * FROM consultas WHERE id_utilizador = '$id_usuario'";
$result = $mysqli->query($sql);

// Check for query errors
if (!$result) {
    die("Erro ao buscar consultas: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Futuras</title>
</head>
<body>
    <h1>Consultas Futuras</h1>
    <ul>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($consulta = $result->fetch_assoc()): ?>
                <li>
                    <strong>Data:</strong> <?php echo htmlspecialchars($consulta['data_consulta']); ?><br>
                    <strong>Observações:</strong> <?php echo htmlspecialchars($consulta['observacoes']); ?><br>
                    <?php
                    // Check if the consultation can be modified (more than 72 hours before the scheduled time)
                    $hours_difference = (strtotime($consulta['data_consulta']) - time()) / 3600;
                    if ($hours_difference > 72): ?>
                        <form action="update_consultation.php" method="POST">
                            <input type="hidden" name="id_consulta" value="<?php echo $consulta['id']; ?>">
                            <label for="nova_data">Nova Data:</label>
                            <input type="datetime-local" id="nova_data" name="nova_data" required>
                            <button type="submit">Alterar Data</button>
                        </form>
                    <?php else: ?>
                        <p><em>Esta consulta não pode ser alterada (menos de 72 horas restantes).</em></p>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li>Nenhuma consulta encontrada.</li>
        <?php endif; ?>
    </ul>
</body>
</html>