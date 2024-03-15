<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Substitua pelos seus dados de conexão
    $host = 'localhost';
    $dbname = 'ajudaqui';
    $user = 'root';
    $pass = '';
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

    $email = $_POST['email'];
    $nome_usuario = $_POST['nome_usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $sql = "INSERT INTO usuarios (email, nome_usuario, senha, is_admin) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$email, $nome_usuario, $senha, $is_admin])) {
        echo "<script>alert('Administrador cadastrado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar administrador.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Administrador</title>
</head>
<body>
    <h2>Cadastro de Administrador</h2>
    <form method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="nome_usuario">Nome de Usuário:</label><br>
        <input type="text" id="nome_usuario" name="nome_usuario" required><br>
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br>
        <label for="is_admin">É administrador:</label>
        <input type="checkbox" id="is_admin" name="is_admin" value="1" checked><br><br>
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
