<?php
session_start(); // Inicia ou continua uma sessão

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../../index.php"); // Redireciona para a página de login
    exit; // Interrompe a execução do script
}

include '../../conexao.php'; // Inclui o arquivo de conexão

// Verifica se o ID da categoria foi enviado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Processamento do formulário de edição
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $icone = $_POST["icone"];
        $descricao = $_POST["descricao"];

        // Atualiza os dados da categoria no banco de dados
        $sql = "UPDATE categoria SET nome_categoria=?, icone=?, descricao=? WHERE id_categoria=?";
        $stmt = $conexao->prepare($sql);

        if ($stmt->execute([$nome, $icone, $descricao, $id])) {
            echo "<script>alert('Categoria atualizada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao atualizar categoria.');</script>";
        }
    }

    // Obtem os dados da categoria
    $sql = "SELECT * FROM categoria WHERE id_categoria = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$id]);
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Categoria</h1>
        <?php if ($categoria): ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $categoria['id_categoria']; ?>">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $categoria['nome_categoria']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="icone">Ícone:</label>
                    <input type="text" class="form-control" id="icone" name="icone" value="<?php echo $categoria['icone']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="descricao" required><?php echo $categoria['descricao']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        <?php else: ?>
            <p class="alert alert-warning">Categoria não encontrada.</p>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
