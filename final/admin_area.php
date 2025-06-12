<?php
session_start();

// Check if the user is logged in and is an administrator
if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo"] !== "administrador") {
    echo "Acesso negado. Apenas administradores podem acessar esta página.";
    exit;
}

// Include database connection
include("conexoes/conexao.php");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa</title>
</head>
<body>
    <h1>Área Administrativa</h1>
    <p>Aqui você pode criar e modificar aspectos da página web.</p>
    <ul>
        <li><a href="manage_users.php">Gerenciar Utilizadores</a></li>
        <li><a href="manage_consultations.php">Gerenciar Consultas</a></li>
        <li><a href="manage_projects.php">Gerenciar Projetos</a></li>
        <li><a href="manage_news.php">Gerenciar Notícias</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>