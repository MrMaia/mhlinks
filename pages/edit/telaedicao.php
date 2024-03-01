<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Categorias, Subcategorias e Links</title>
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
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn-editar,
        .btn-excluir {
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

                // Processamento do botão de exclusão de categoria
                if (isset($_POST['excluir_categoria_id'])) {
                    $id = $_POST['excluir_categoria_id'];
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
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_categoria"] . "</td>";
                        echo "<td>" . $row["icone"] . "</td>";
                        echo "<td>" . $row["nome_categoria"] . "</td>";
                        echo "<td>" . $row["descricao"] . "</td>";
                        echo "<td>";
                        echo "<button class='btn-editar' onclick='editarCategoria(" . $row["id_categoria"] . ")'>Editar</button>";
                        echo "<form method='post' onsubmit='return confirm(\"Tem certeza que deseja excluir esta categoria?\")'>";
                        echo "<input type='hidden' name='excluir_categoria_id' value='" . $row["id_categoria"] . "'>";
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

        <h1>Listagem de Subcategorias</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoria</th>
                    <th>Ícone</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Verifica a conexão
                if ($conn->connect_error) {
                    die("Falha na conexão: " . $conn->connect_error);
                }

                // Processamento do botão de exclusão de subcategoria
                if (isset($_POST['excluir_subcategoria_id'])) {
                    $id = $_POST['excluir_subcategoria_id'];
                    $sql_delete = "DELETE FROM sub_categoria WHERE id_sub_categoria = $id";
                    if ($conn->query($sql_delete) === TRUE) {
                        echo "<p>Subcategoria excluída com sucesso!</p>";
                    } else {
                        echo "<p>Erro ao excluir subcategoria: " . $conn->error . "</p>";
                    }
                }

                // Query para selecionar todas as subcategorias
                $sql_sub = "SELECT sub_categoria.*, categoria.nome_categoria 
                            FROM sub_categoria 
                            INNER JOIN categoria 
                            ON sub_categoria.id_categoria = categoria.id_categoria";
                $result_sub = $conn->query($sql_sub);

                // Verifica se há resultados e lista as subcategorias
                if ($result_sub->num_rows > 0) {
                    while ($row_sub = $result_sub->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_sub["id_sub_categoria"] . "</td>";
                        echo "<td>" . $row_sub["nome_categoria"] . "</td>";
                        echo "<td>" . $row_sub["icone"] . "</td>";
                        echo "<td>" . $row_sub["nome"] . "</td>";
                        echo "<td>" . $row_sub["descricao"] . "</td>";
                        echo "<td>";
                        echo "<button class='btn-editar' onclick='editarSubcategoria(" . $row_sub["id_sub_categoria"] . ")'>Editar</button>";
                        echo "<form method='post' onsubmit='return confirm(\"Tem certeza que deseja excluir esta subcategoria?\")'>";
                        echo "<input type='hidden' name='excluir_subcategoria_id' value='" . $row_sub["id_sub_categoria"] . "'>";
                        echo "<button type='submit' class='btn-excluir'>Excluir</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhuma subcategoria encontrada.</td></tr>";
                }

                // Fecha a conexão
                $conn->close();
                ?>
            </tbody>
        </table>

        <h1>Listagem de Links</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoria</th>
                    <th>Subcategoria</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Link</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Verifica a conexão
                if ($conn->connect_error) {
                    die("Falha na conexão: " . $conn->connect_error);
                }

                // Processamento do botão de exclusão de link
                if (isset($_POST['excluir_link_id'])) {
                    $id = $_POST['excluir_link_id'];
                    $sql_delete = "DELETE FROM link WHERE id_link = $id";
                    if ($conn->query($sql_delete) === TRUE) {
                        echo "<p>Link excluído com sucesso!</p>";
                    } else {
                        echo "<p>Erro ao excluir link: " . $conn->error . "</p>";
                    }
                }

                // Query para selecionar todos os links
                $sql_link = "SELECT link.*, categoria.nome_categoria, sub_categoria.nome AS nome_subcategoria 
                             FROM link 
                             INNER JOIN categoria ON link.id_categoria = categoria.id_categoria 
                             INNER JOIN sub_categoria ON link.id_sub_categoria = sub_categoria.id_sub_categoria";
                $result_link = $conn->query($sql_link);

                // Verifica se há resultados e lista os links
                if ($result_link->num_rows > 0) {
                    while ($row_link = $result_link->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_link["id_link"] . "</td>";
                        echo "<td>" . $row_link["nome_categoria"] . "</td>";
                        echo "<td>" . $row_link["nome_subcategoria"] . "</td>";
                        echo "<td>" . $row_link["imagem"] . "</td>";
                        echo "<td>" . $row_link["nome"] . "</td>";
                        echo "<td>" . $row_link["descricao"] . "</td>";
                        echo "<td><a href='" . $row_link["link"] . "' target='_blank'>" . $row_link["link"] . "</a></td>";
                        echo "<td>";
                        echo "<button class='btn-editar' onclick='editarLink(" . $row_link["id_link"] . ")'>Editar</button>";
                        echo "<form method='post' onsubmit='return confirm(\"Tem certeza que deseja excluir este link?\")'>";
                        echo "<input type='hidden' name='excluir_link_id' value='" . $row_link["id_link"] . "'>";
                        echo "<button type='submit' class='btn-excluir'>Excluir</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Nenhum link encontrado.</td></tr>";
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

        function editarSubcategoria(id) {
            window.location.href = "editar_subcategoria.php?id=" + id;
        }

        function editarLink(id) {
            window.location.href = "editar_link.php?id=" + id;
        }
    </script>
</body>

</html>