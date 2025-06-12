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

// Determine if the user is an administrator
$is_admin = ($_SESSION["tipo"] === "administrador");

// Get the user ID from the query string
$id = $mysqli->real_escape_string($_GET['id'] ?? $_SESSION["id_usuario"]);

// If the user is not an administrator, ensure they can only edit their own data
if (!$is_admin && $id != $_SESSION["id_usuario"]) {
    echo "Acesso negado. Você só pode editar seus próprios dados.";
    exit;
}

// Fetch user details
$sql = "SELECT * FROM utilizadores WHERE id = '$id'";
$result = $mysqli->query($sql);

if ($result->num_rows === 0) {
    die("Utilizador não encontrado.");
}

$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $apelido = $mysqli->real_escape_string($_POST['apelido']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $telefone = $mysqli->real_escape_string($_POST['telefone']);

    // Update user details
    $stmt = $mysqli->prepare("UPDATE utilizadores SET nome = ?, apelido = ?, email = ?, telefone = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nome, $apelido, $email, $telefone, $id);

    if ($stmt->execute()) {
        echo "Dados pessoais atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar dados pessoais: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dados Pessoais</title>
</head>
<body>
    <h1>Editar Dados Pessoais</h1>
    <form action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
        <br>
        <label for="apelido">Apelido:</label>
        <input type="text" id="apelido" name="apelido" value="<?php echo htmlspecialchars($user['apelido']); ?>" required>
        <br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <br>
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($user['telefone']); ?>">
        <br>
        <button type="submit">Atualizar</button>
    </form>
</body>
</html>