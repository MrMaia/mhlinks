<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Categoria</h1>
        <?php
        // Verifica se o ID da categoria foi enviado via GET
        if(isset($_GET['id'])) {
            // Conexão com o banco de dados
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "ajudaqui";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verifica a conexão
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }

            // Processamento do formulário de edição
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id = $_POST["id"];
                $nome = $_POST["nome"];
                $icone = $_POST["icone"];
                $descricao = $_POST["descricao"];

                // Atualiza os dados da categoria no banco de dados
                $sql = "UPDATE categoria SET nome_categoria='$nome', icone='$icone', descricao='$descricao' WHERE id_categoria=$id";

                if ($conn->query($sql) === TRUE) {
                    echo "<p>Categoria atualizada com sucesso!</p>";
                } else {
                    echo "<p>Erro ao atualizar categoria: " . $conn->error . "</p>";
                }
            }

            // Prepara e executa a consulta para obter os dados da categoria com base no ID
            $id = $_GET['id'];
            $sql = "SELECT * FROM categoria WHERE id_categoria = $id";
            $result = $conn->query($sql);

            // Verifica se há resultados
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Exibição do formulário de edição com os dados atuais da categoria
        ?>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $row['id_categoria']; ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $row['nome_categoria']; ?>">
            <label for="icone">Ícone:</label>
            <input type="text" id="icone" name="icone" value="<?php echo $row['icone']; ?>">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao"><?php echo $row['descricao']; ?></textarea>
            <input type="submit" value="Atualizar">
        </form>
        <?php
            } else {
                echo "<p>Categoria não encontrada.</p>";
            }

            // Fecha a conexão
            $conn->close();
        } else {
            echo "<p>ID da categoria não especificado.</p>";
        }
        ?>
    </div>
</body>
</html>
