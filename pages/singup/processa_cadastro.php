<?php
$servername = "localhost";
$username = "root"; // Seu usuário do MySQL
$password = ""; // Sua senha do MySQL
$dbname = "ajudaqui";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receber dados do formulário
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$is_admin = 0; // Por padrão, o usuário não é um administrador

// Preparar e vincular
$stmt = $conn->prepare("INSERT INTO usuarios (username, password, is_admin) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $username, $password, $is_admin);

// Executar
if ($stmt->execute()) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
