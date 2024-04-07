<?php
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../../index.php"); // Ajuste o caminho conforme necessário
    exit;
}

include '../../conexao.php'; // Substitua pelo caminho correto até seu arquivo conexao.php

// Processamento do formulário de edição e busca dos dados do link
if (isset($_GET['id']) || isset($_POST['id'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $link = $_POST["link"];

        $sql = "UPDATE link SET nome=?, descricao=?, link=? WHERE id_link=?";
        $stmt = $conexao->prepare($sql);
        if ($stmt->execute([$nome, $descricao, $link, $id])) {
            echo "<script>alert('Link atualizado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao atualizar link.');</script>";
        }
    }

    $sql = "SELECT * FROM link WHERE id_link = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Link</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Link</h1>
        <?php if (isset($row)): ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['id_link']; ?>">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $row['nome']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="descricao" required><?php echo $row['descricao']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="link">Link:</label>
                    <input type="text" class="form-control" id="link" name="link" value="<?php echo $row['link']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        <?php else: ?>
            <p>Link não encontrado.</p>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
