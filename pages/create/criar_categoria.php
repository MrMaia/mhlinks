<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos do formulário estão preenchidos
    if (!empty($_POST['icone']) && !empty($_POST['nome_categoria']) && !empty($_POST['descricao'])) {
        // Inclui o arquivo de conexão
        include '../../conexao.php';

        // Prepara a instrução SQL para inserir dados na tabela categoria
        $sql = "INSERT INTO categoria (icone, nome_categoria, descricao) VALUES (:icone, :nome_categoria, :descricao)";

        try {
            // Prepara a consulta
            $stmt = $conexao->prepare($sql);

            // Vincula os parâmetros
            $stmt->bindParam(':icone', $_POST['icone']);
            $stmt->bindParam(':nome_categoria', $_POST['nome_categoria']);
            $stmt->bindParam(':descricao', $_POST['descricao']);

            // Executa a consulta
            $stmt->execute();

            // Verifica se a consulta foi bem-sucedida
            if ($stmt->rowCount() > 0) {
                echo "Dados inseridos com sucesso!";
            } else {
                echo "Erro ao inserir os dados.";
            }
        } catch (PDOException $e) {
            echo "Erro ao inserir os dados: " . $e->getMessage();
        }
    } else {
        echo "Todos os campos do formulário devem ser preenchidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>AjudaQui - Seu site dos links</title>

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

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="icone">Cole o código do ícone:</label><br>
        <input type="text" id="icone" name="icone" required><br><br>

        <label for="nome_categoria">Nome da Categoria:</label><br>
        <input type="text" id="nome_categoria" name="nome_categoria" required><br><br>

        <label for="descricao">Descrição da Categoria:</label><br>
        <textarea id="descricao" name="descricao" required></textarea><br><br>

        <input type="submit" value="Enviar">
    </form>

</body>