<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

// Include database connection
include("conexoes/conexao.php");

// Fetch user details
$id_usuario = $_SESSION["id_usuario"];
$sql = "SELECT * FROM utilizadores WHERE id = '$id_usuario'";
$result = $mysqli->query($sql);
$utilizador = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Utilizador</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($utilizador["nome"]); ?>!</h1>

    <h2>Opções Disponíveis</h2>
    <ul>
        <li><a href="edit_profile.php">Editar Dados Pessoais</a></li>
        <li><a href="schedule_consultation.php">Marcar Consulta</a></li>
        <li><a href="view_consultations.php">Visualizar Consultas Futuras</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>