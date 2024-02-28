<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Link</title>
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
        <h1>Editar Link</h1>
        <?php
        // Verifica se o ID do link foi enviado via GET
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
                $descricao = $_POST["descricao"];
                $link = $_POST["link"];

                // Atualiza os dados do link no banco de dados
                $sql = "UPDATE link SET nome='$nome', descricao='$descricao', link='$link' WHERE id_link=$id";

                if ($conn->query($sql) === TRUE) {
                    echo "<p>Link atualizado com sucesso!</p>";
                } else {
                    echo "<p>Erro ao atualizar link: " . $conn->error . "</p>";
                }
            }

            // Prepara e executa a consulta para obter os dados do link com base no ID
            $id = $_GET['id'];
            $sql = "SELECT * FROM link WHERE id_link = $id";
            $result = $conn->query($sql);

            // Verifica se há resultados
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Exibição do formulário de edição com os dados atuais do link
        ?>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $row['id_link']; ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $row['nome']; ?>">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao"><?php echo $row['descricao']; ?></textarea>
            <label for="link">Link:</label>
            <input type="text" id="link" name="link" value="<?php echo $row['link']; ?>">
            <input type="submit" value="Atualizar">
        </form>
        <?php
            } else {
                echo "<p>Link não encontrado.</p>";
            }

            // Fecha a conexão
            $conn->close();
        } else {
            echo "<p>ID do link não especificado.</p>";
        }
        ?>
    </div>
</body>
</html>
