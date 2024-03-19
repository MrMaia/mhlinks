<?php
session_start(); // Inicia ou continua uma sessão

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../../index.php"); // Redireciona para a página de login
    exit; // Interrompe a execução do script
}

include '../../conexao.php'; // Inclui o arquivo de conexão

// Verifica se o ID do usuário foi enviado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Processamento do formulário de edição
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome_usuario = $_POST["nome_usuario"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $is_admin = isset($_POST["is_admin"]) ? 1 : 0;

        // Verifica se a senha não está em branco
        if (!empty($senha)) {
            // Atualiza os dados do usuário incluindo a senha
            $sql = "UPDATE usuarios SET nome_usuario=?, email=?, senha=?, is_admin=? WHERE id=?";
            $stmt = $conexao->prepare($sql);

            // Hash da senha
            $hashed_senha = password_hash($senha, PASSWORD_DEFAULT);

            if ($stmt->execute([$nome_usuario, $email, $hashed_senha, $is_admin, $id])) {
                echo "<script>alert('Usuário atualizado com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao atualizar usuário.');</script>";
            }
        } else {
            // Atualiza os dados do usuário sem alterar a senha
            $sql = "UPDATE usuarios SET nome_usuario=?, email=?, is_admin=? WHERE id=?";
            $stmt = $conexao->prepare($sql);

            if ($stmt->execute([$nome_usuario, $email, $is_admin, $id])) {
                echo "<script>alert('Usuário atualizado com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao atualizar usuário.');</script>";
            }
        }
    }

    // Obtem os dados do usuário
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Usuário</h1>
        <?php if ($usuario): ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                <div class="form-group">
                    <label for="nome_usuario">Nome de Usuário:</label>
                    <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" value="<?php echo $usuario['nome_usuario']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha">
                    <small class="form-text text-muted">Deixe em branco para manter a senha atual.</small>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" <?php echo $usuario['is_admin'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="is_admin">É administrador?</label>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        <?php else: ?>
            <p class="alert alert-warning">Usuário não encontrado.</p>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
