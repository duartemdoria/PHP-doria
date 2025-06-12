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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $apelido = $mysqli->real_escape_string($_POST['apelido']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $telefone = $mysqli->real_escape_string($_POST['telefone']);
    $password = $_POST['password']; // Plain text password
    $tipo = $mysqli->real_escape_string($_POST['tipo']);

    // Encrypt the password using bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email is unique
    $check_email = $mysqli->query("SELECT * FROM utilizadores WHERE email = '$email'");
    if ($check_email->num_rows > 0) {
        echo "Erro: O e-mail já está em uso.";
        exit;
    }

    // Insert the user into the database
    $stmt = $mysqli->prepare("INSERT INTO utilizadores (nome, apelido, email, telefone, password, tipo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nome, $apelido, $email, $telefone, $hashed_password, $tipo);

    if ($stmt->execute()) {
        echo "Utilizador registrado com sucesso!";
    } else {
        echo "Erro ao registrar utilizador: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Utilizador</title>
</head>
<body>
    <h1>Registrar Utilizador</h1>
    <form action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br>
        <label for="apelido">Apelido:</label>
        <input type="text" id="apelido" name="apelido" required>
        <br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone">
        <br>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="utilizador">Utilizador</option>
            <option value="administrador">Administrador</option>
        </select>
        <br>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>