<?php
include("../../conexoes/conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST["email"]) || isset($_POST['password'])) {

    if (!isset($_POST['email']) || strlen($_POST['email']) == 0) {
        echo "Preencha o seu e-mail!";
    } else if (!isset($_POST['password']) || strlen($_POST['password']) == 0) {
        echo "Preencha a sua password!";
    } else {

        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $_POST['password']; // Plain text password

        $sql_code = "SELECT * FROM utilizadores WHERE email='$email'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código: " . $mysqli->error);

        if ($sql_query->num_rows == 1) {
            $utilizador = $sql_query->fetch_assoc();

            // Verify the password
            if (password_verify($password, $utilizador['password'])) {
                $_SESSION["id_usuario"] = $utilizador["id"];
                $_SESSION["nome"] = $utilizador["nome"];
                $_SESSION["tipo"] = $utilizador["tipo"];

                header("Location: index.php");
                exit;
            } else {
                echo "Falha ao entrar! Dados incorretos.";
            }
        } else {
            echo "Falha ao entrar! Dados incorretos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="" method="POST">
        <h1>Login</h1>
        <p>
            <label>E-mail</label>
            <input type="text" name="email">
        </p>
        <p>
            <label>Password</label>
            <input type="password" name="password">
        </p>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>