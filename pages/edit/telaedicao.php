<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Categorias</h2>
        <ul class="list-group">
            <?php
            // Include do arquivo de conexão
            include '../../conexao.php';

            // Função para buscar categorias
            function getCategorias($conexao) {
                $query = "SELECT * FROM categoria";
                $stmt = $conexao->query($query);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            // Exibir categorias
            $categorias = getCategorias($conexao);
            foreach ($categorias as $categoria) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                echo $categoria['nome_categoria'];
                echo '<div>';
                echo '<a href="editar_categoria.php?id=' . $categoria['id_categoria'] . '" class="btn btn-primary btn-sm mr-2">Editar</a>';
                echo '<a href="excluir_categoria.php?id=' . $categoria['id_categoria'] . '" class="btn btn-danger btn-sm">Excluir</a>';
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>

        <h2>Links</h2>
        <ul class="list-group">
            <?php
            // Função para buscar links
            function getLinks($conexao) {
                $query = "SELECT * FROM link";
                $stmt = $conexao->query($query);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            // Exibir links
            $links = getLinks($conexao);
            foreach ($links as $link) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                echo $link['nome'];
                echo '<div>';
                echo '<a href="editar_link.php?id=' . $link['id_link'] . '" class="btn btn-primary btn-sm mr-2">Editar</a>';
                echo '<a href="excluir_link.php?id=' . $link['id_link'] . '" class="btn btn-danger btn-sm">Excluir</a>';
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>

        <h2>Subcategorias</h2>
        <ul class="list-group">
            <?php
            // Função para buscar subcategorias
            function getSubcategorias($conexao) {
                $query = "SELECT * FROM sub_categoria";
                $stmt = $conexao->query($query);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            // Exibir subcategorias
            $subcategorias = getSubcategorias($conexao);
            foreach ($subcategorias as $subcategoria) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                echo $subcategoria['nome'];
                echo '<div>';
                echo '<a href="editar_subcategoria.php?id=' . $subcategoria['id_sub_categoria'] . '" class="btn btn-primary btn-sm mr-2">Editar</a>';
                echo '<a href="excluir_subcategoria.php?id=' . $subcategoria['id_sub_categoria'] . '" class="btn btn-danger btn-sm">Excluir</a>';
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>

        <h2>Usuários</h2>
        <ul class="list-group">
            <?php
            // Função para buscar usuários
            function getUsuarios($conexao) {
                $query = "SELECT * FROM usuarios";
                $stmt = $conexao->query($query);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            // Exibir usuários
            $usuarios = getUsuarios($conexao);
            foreach ($usuarios as $usuario) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                echo $usuario['nome_usuario'];
                echo '<div>';
                echo '<a href="editar_usuario.php?id=' . $usuario['id'] . '" class="btn btn-primary btn-sm mr-2">Editar</a>';
                echo '<a href="excluir_usuario.php?id=' . $usuario['id'] . '" class="btn btn-danger btn-sm">Excluir</a>';
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</body>
</html>
