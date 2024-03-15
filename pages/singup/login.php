<?php
session_start(); // Inicia a sessão no início do arquivo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $dbname = 'ajudaqui';
    $user = 'root';
    $pass = '';
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, senha, is_admin FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Armazena informações do usuário na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['is_admin'] = $usuario['is_admin'];
        header("Location: ../../index.php"); // Redireciona para index.php
        exit();
    } else {
        $erro_login = "Email ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>
        <input type="submit" value="Entrar">
    </form>
    <?php if (!empty($erro_login)): ?>
        <p><?php echo $erro_login; ?></p>
    <?php endif; ?>
</body>
</html>
