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

// Fetch all users
$sql = "SELECT * FROM utilizadores";
$result = $mysqli->query($sql);

// Check for query errors
if (!$result) {
    die("Erro ao buscar utilizadores: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Utilizadores</title>
</head>
<body>
    <h1>Gerenciar Utilizadores</h1>
    <ul>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($user = $result->fetch_assoc()): ?>
                <li>
                    <strong>Nome:</strong> <?php echo htmlspecialchars($user['nome']); ?><br>
                    <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?><br>
                    <strong>Telefone:</strong> <?php echo htmlspecialchars($user['telefone']); ?><br>
                    <strong>Tipo:</strong> <?php echo htmlspecialchars($user['tipo']); ?><br>
                    <a href="../user/edit_user.php?id=<?php echo $user['id']; ?>">Editar</a>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li>Nenhum utilizador encontrado.</li>
        <?php endif; ?>
    </ul>
</body>
</html>