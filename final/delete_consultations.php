<?php
include("conexoes/conexao.php");

if (!isset($_SESSION)) {
    session_start();

// Check if the user is logged in and is an administrator
if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo"] !== "administrador") {
    echo "Acesso negado. Apenas administradores podem acessar esta página.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_consulta = $mysqli->real_escape_string($_POST['id_consulta']);

    // Delete the consultation
    $stmt = $mysqli->prepare("DELETE FROM consultas WHERE id = ?");
    $stmt->bind_param("i", $id_consulta);

    if ($stmt->execute()) {
        echo "Consulta excluída com sucesso!";
    } else {
        echo "Erro ao excluir consulta: " . $stmt->error;
    }

    $stmt->close();
}
?>