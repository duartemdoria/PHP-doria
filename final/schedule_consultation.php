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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_consulta = $mysqli->real_escape_string($_POST['data_consulta']);
    $observacoes = $mysqli->real_escape_string($_POST['observacoes']);
    $id_usuario = $_SESSION['id_usuario'];

    // Insert the consultation into the database
    $stmt = $mysqli->prepare("INSERT INTO consultas (id_utilizador, data_consulta, observacoes) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_usuario, $data_consulta, $observacoes);

    if ($stmt->execute()) {
        echo "Consulta marcada com sucesso!";
    } else {
        echo "Erro ao marcar consulta: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcar Consulta</title>
</head>
<body>
    <h1>Marcar Consulta</h1>
    <form action="" method="POST">
        <label for="data_consulta">Data da Consulta:</label>
        <input type="datetime-local" id="data_consulta" name="data_consulta" required>
        <br>
        <label for="observacoes">Observações:</label>
        <textarea id="observacoes" name="observacoes"></textarea>
        <br>
        <button type="submit">Marcar Consulta</button>
    </form>
</body>
</html>