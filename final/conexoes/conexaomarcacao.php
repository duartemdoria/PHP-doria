<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    echo "Erro: Utilizador não autenticado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data_reuniao'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';
    $id_usuario = $_SESSION['id_usuario'];

    if (empty($data)) {
        echo "Erro: A data da reunião é obrigatória.";
        exit;
    }


    $stmt = $conn->prepare("INSERT INTO consultas (id_usuario, data_reuniao, observacoes) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_usuario, $data, $observacoes);

    if ($stmt->execute()) {
        echo "Reunião marcada com sucesso!";
    } else {
        echo "Erro ao marcar reunião: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
