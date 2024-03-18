<?php
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../../index.php"); // Ajuste o caminho conforme necessário
    exit;
}

include '../../conexao.php'; // Substitua pelo caminho correto até seu arquivo conexao.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $nome_usuario = $_POST['nome_usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $sql = "INSERT INTO usuarios (email, nome_usuario, senha, is_admin) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);

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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Cadastro de Administrador</h2>
        <form method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="nome_usuario">Nome de Usuário:</label>
                <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1" checked>
                <label class="form-check-label" for="is_admin">É administrador</label>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
