<?php
session_start();

$servername = "localhost";
$username = "root"; // Seu usuário do MySQL
$password = ""; // Sua senha do MySQL
$dbname = "ajudaqui";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, password, is_admin FROM usuarios WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['is_admin'] = $row['is_admin']; // Armazena se o usuário é admin
        
        header("Location: ../../index.php"); // Redireciona para a página protegida
        exit;
    } else {
        echo "Senha incorreta!";
    }
} else {
    echo "Usuário não encontrado!";
}

$stmt->close();
$conn->close();
?>
