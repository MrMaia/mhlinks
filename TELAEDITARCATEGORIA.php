<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Categorias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn-editar, .btn-excluir {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .btn-editar {
            background-color: #4CAF50;
            color: white;
        }

        .btn-excluir {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Listagem de Categorias</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ícone</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
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

                // Processamento do botão de exclusão
                if(isset($_POST['excluir_id'])) {
                    $id = $_POST['excluir_id'];
                    $sql_delete = "DELETE FROM categoria WHERE id_categoria = $id";
                    if ($conn->query($sql_delete) === TRUE) {
                        echo "<p>Categoria excluída com sucesso!</p>";
                    } else {
                        echo "<p>Erro ao excluir categoria: " . $conn->error . "</p>";
                    }
                }

                // Query para selecionar todas as categorias
                $sql = "SELECT * FROM categoria";
                $result = $conn->query($sql);

                // Verifica se há resultados e lista as categorias
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_categoria"] . "</td>";
                        echo "<td>" . $row["icone"] . "</td>";
                        echo "<td>" . $row["nome_categoria"] . "</td>";
                        echo "<td>" . $row["descricao"] . "</td>";
                        echo "<td>";
                        echo "<button class='btn-editar' onclick='editarCategoria(" . $row["id_categoria"] . ")'>Editar</button>";
                        echo "<form method='post' onsubmit='return confirm(\"Tem certeza que deseja excluir esta categoria?\")'>";
                        echo "<input type='hidden' name='excluir_id' value='" . $row["id_categoria"] . "'>";
                        echo "<button type='submit' class='btn-excluir'>Excluir</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhuma categoria encontrada.</td></tr>";
                }

                // Fecha a conexão
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function editarCategoria(id) {
            window.location.href = "editar_categoria.php?id=" + id;
        }
    </script>
</body>
</html>
