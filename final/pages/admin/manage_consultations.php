<?php
include("../../conexoes/conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

// Check if the user is logged in and is an administrator
if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo"] !== "administrador") {
    echo "Acesso negado. Apenas administradores podem acessar esta página.";
    exit;
}

// Fetch all consultations
$sql = "SELECT consultas.id, consultas.data_consulta, consultas.observacoes, utilizadores.nome AS nome_utilizador 
        FROM consultas 
        JOIN utilizadores ON consultas.id_utilizador = utilizadores.id";
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
    <title>Gerenciar Consultas</title>
</head>
<body>
    <h1>Gerenciar Consultas</h1>
    <ul>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($consulta = $result->fetch_assoc()): ?>
                <li>
                    <strong>Utilizador:</strong> <?php echo htmlspecialchars($consulta['nome_utilizador']); ?><br>
                    <strong>Data:</strong> <?php echo htmlspecialchars($consulta['data_consulta']); ?><br>
                    <strong>Observações:</strong> <?php echo htmlspecialchars($consulta['observacoes']); ?><br>
                    <form action="../user/update_consultations.php" method="POST">
                        <input type="hidden" name="id_consulta" value="<?php echo $consulta['id']; ?>">
                        <label for="nova_data">Nova Data:</label>
                        <input type="datetime-local" id="nova_data" name="nova_data" required>
                        <button type="submit">Alterar Data</button>
                    </form>
                    <form action="delete_consultations.php" method="POST">
                        <input type="hidden" name="id_consulta" value="<?php echo $consulta['id']; ?>">
                        <button type="submit">Excluir Consulta</button>
                    </form>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li>Nenhuma consulta encontrada.</li>
        <?php endif; ?>
    </ul>
</body>
</html>