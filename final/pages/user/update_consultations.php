<?php
include("../../conexoes/conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_consulta = $mysqli->real_escape_string($_POST['id_consulta']);
    $nova_data = $mysqli->real_escape_string($_POST['nova_data']);

    // Update the consultation date
    $stmt = $mysqli->prepare("UPDATE consultas SET data_consulta = ? WHERE id = ? AND TIMESTAMPDIFF(HOUR, NOW(), data_consulta) > 72");
    $stmt->bind_param("si", $nova_data, $id_consulta);

    if ($stmt->execute()) {
        echo "Data da consulta alterada com sucesso!";
    } else {
        echo "Erro ao alterar data da consulta: " . $stmt->error;
    }

    $stmt->close();
}
?>