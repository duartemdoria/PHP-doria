<?php
include("../conexoes/conexao.php");

// Fetch all users
$sql = "SELECT id, password FROM utilizadores";
$result = $mysqli->query($sql);

if (!$result) {
    die("Erro ao buscar utilizadores: " . $mysqli->error);
}

while ($user = $result->fetch_assoc()) {
    $id = $user['id'];
    $plain_password = $user['password'];

    // Debugging: Output the original password
    echo "Original password for user ID $id: $plain_password<br>";

    // Hash the plain text password
    $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

    // Debugging: Output the hashed password
    echo "Hashed password for user ID $id: $hashed_password<br>";

    // Update the password in the database
    $update_sql = "UPDATE utilizadores SET password = ? WHERE id = ?";
    $stmt = $mysqli->prepare($update_sql);
    $stmt->bind_param("si", $hashed_password, $id);

    if ($stmt->execute()) {
        echo "Senha atualizada para o utilizador com ID: $id<br>";
    } else {
        echo "Erro ao atualizar senha para o utilizador com ID: $id - " . $stmt->error . "<br>";
    }

    $stmt->close();
}

echo "Todas as senhas foram atualizadas com sucesso!";
?>

//Open your browser and navigate to http://localhost/final/hash_passwords.php