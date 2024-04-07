<?php
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../../index.php"); // Ajuste o caminho conforme necessário
    exit;
}

include '../../conexao.php'; // Substitua pelo caminho correto até seu arquivo conexao.php

if (isset($_GET['id']) || isset($_POST['id'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $icone = $_POST["icone"];
        $descricao = $_POST["descricao"];

        $sql = "UPDATE sub_categoria SET nome=?, icone=?, descricao=? WHERE id_sub_categoria=?";
        $stmt = $conexao->prepare($sql);
        if ($stmt->execute([$nome, $icone, $descricao, $id])) {
            echo "<script>alert('Subcategoria atualizada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao atualizar subcategoria.');</script>";
        }
    }

    $sql = "SELECT * FROM sub_categoria WHERE id_sub_categoria = ?";
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
    <title>Editar Subcategoria</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Subcategoria</h1>
        <?php if (isset($row)): ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['id_sub_categoria']; ?>">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($row['nome']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="icone">Ícone:</label>
                    <input type="text" class="form-control" id="icone" name="icone" value="<?php echo htmlspecialchars($row['icone']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="descricao" required><?php echo htmlspecialchars($row['descricao']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        <?php else: ?>
            <p>Subcategoria não encontrada.</p>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
