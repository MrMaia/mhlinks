<?php
// Inclui o arquivo de conexão
include '../../conexao.php';

// Recupera todas as categorias do banco de dados
$categorias = [];
try {
    $stmt = $conexao->query("SELECT id_categoria, nome_categoria FROM categoria");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar categorias: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>AjudaQui - Criar Subcategoria</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="coderdocs-logo.ico">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <!-- FontAwesome JS-->
    <script defer src="../../assets/fontawesome/js/all.min.js"></script>
    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="../../assets/css/theme.css">
</head>

<body>
    <?php include '../../partials/header.php'; ?>

    <h2>Criar Subcategoria</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="icone">Cole o código do ícone:</label><br>
        <input type="text" id="icone" name="icone" required><br><br>

        <label for="nome_sub_categoria">Nome da Sub-Categoria:</label><br>
        <input type="text" id="nome_sub_categoria" name="nome_sub_categoria" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao" required></textarea><br><br>

        <label for="id_categoria">A qual categoria vai ser vinculada?</label><br>
        <select id="id_categoria" name="id_categoria" required>
            <option value="">Selecione...</option>
            <?php foreach ($categorias as $categoria) : ?>
                <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nome_categoria']; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Enviar">
    </form>

    <?php
    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica se todos os campos do formulário estão preenchidos
        if (!empty($_POST['icone']) && !empty($_POST['nome_sub_categoria']) && !empty($_POST['descricao']) && !empty($_POST['id_categoria'])) {
            // Prepara a instrução SQL para inserir dados na tabela sub_categoria
            $sql = "INSERT INTO sub_categoria (id_categoria, icone, nome, descricao) VALUES (:id_categoria, :icone, :nome_sub_categoria, :descricao)";

            try {
                // Prepara a consulta
                $stmt = $conexao->prepare($sql);

                // Vincula os parâmetros
                $stmt->bindParam(':id_categoria', $_POST['id_categoria']);
                $stmt->bindParam(':icone', $_POST['icone']);
                $stmt->bindParam(':nome_sub_categoria', $_POST['nome_sub_categoria']);
                $stmt->bindParam(':descricao', $_POST['descricao']);

                // Executa a consulta
                if ($stmt->execute()) {
                    echo "Subcategoria criada com sucesso!";
                } else {
                    echo "Erro ao criar a subcategoria.";
                }
            } catch (PDOException $e) {
                echo "Erro ao criar a subcategoria: " . $e->getMessage();
            }
        } else {
            echo "Todos os campos do formulário devem ser preenchidos.";
        }
    }
    ?>

</body>

</html>