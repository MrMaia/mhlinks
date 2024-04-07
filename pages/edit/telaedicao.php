<?php
session_start(); // Inicia ou continua uma sessão

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../../index.php"); // Redireciona para a página de login
    exit; // Interrompe a execução do script
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="container mt-5">
        <!-- Categorias -->
        <h2>Categorias</h2>
        <ul class="list-group">
            <?php
            include '../../conexao.php';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = $_POST['id'] ?? 0;
                $tipo = $_POST['tipo'] ?? '';
                $query = "";
                switch ($tipo) {
                    case 'categoria':
                        $query = "DELETE FROM categoria WHERE id_categoria=:id";
                        break;
                    case 'link':
                        $query = "DELETE FROM link WHERE id_link=:id";
                        break;
                    case 'subcategoria':
                        $query = "DELETE FROM sub_categoria WHERE id_sub_categoria=:id";
                        break;
                    case 'usuario':
                        $query = "DELETE FROM usuarios WHERE id=:id";
                        break;
                }
                if ($query) {
                    $stmt = $conexao->prepare($query);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    echo "<script>Swal.fire({
                        title: 'Deletado!',
                        text: 'O item foi deletado.',
                        icon: 'success'
                    }).then(() => {
                        Swal.close();
                    });
                    </script>";
                }
            }

            $categorias = $conexao->query("SELECT * FROM categoria")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($categorias as $categoria) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                echo htmlspecialchars($categoria['nome_categoria']);
                echo '<div>';
                echo '<a href="editar_categoria.php?id=' . $categoria['id_categoria'] . '" class="btn btn-primary btn-sm mr-2">Editar</a>';
                echo '<button onclick="excluir(\'categoria\', ' . $categoria['id_categoria'] . ')" class="btn btn-danger btn-sm">Excluir</button>';
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>

        <!-- Subcategorias -->
        <h2>Subcategorias</h2>
        <ul class="list-group">
            <?php
            $subcategorias = $conexao->query("SELECT * FROM sub_categoria")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($subcategorias as $subcategoria) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                echo htmlspecialchars($subcategoria['nome']);
                echo '<div>';
                echo '<a href="editar_subcategoria.php?id=' . $subcategoria['id_sub_categoria'] . '" class="btn btn-primary btn-sm mr-2">Editar</a>';
                echo '<button onclick="excluir(\'subcategoria\', ' . $subcategoria['id_sub_categoria'] . ')" class="btn btn-danger btn-sm">Excluir</button>';
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>

        <!-- Links -->
        <h2>Links</h2>
        <ul class="list-group">
            <?php
            $links = $conexao->query("SELECT * FROM link")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($links as $link) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                echo htmlspecialchars($link['nome']);
                echo '<div>';
                echo '<a href="editar_link.php?id=' . $link['id_link'] . '" class="btn btn-primary btn-sm mr-2">Editar</a>';
                echo '<button onclick="excluir(\'link\', ' . $link['id_link'] . ')" class="btn btn-danger btn-sm">Excluir</button>';
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>

        <!-- Usuários -->
        <h2>Usuários</h2>
        <ul class="list-group">
            <?php
            $usuarios = $conexao->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($usuarios as $usuario) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                echo htmlspecialchars($usuario['nome_usuario']);
                echo '<div>';
                echo '<a href="editar_usuario.php?id=' . $usuario['id'] . '" class="btn btn-primary btn-sm mr-2">Editar</a>';
                echo '<button onclick="excluir(\'usuario\', ' . $usuario['id'] . ')" class="btn btn-danger btn-sm">Excluir</button>';
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>

    <form id="deleteForm" method="post" style="display: none;">
        <input type="hidden" name="id" id="deleteId">
        <input type="hidden" name="tipo" id="deleteTipo">
    </form>

    <script>
        function excluir(tipo, id) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Fecha o SweetAlert imediatamente
                    Swal.close();

                    // Continua com a submissão do formulário ou ação de exclusão
                    document.getElementById('deleteId').value = id;
                    document.getElementById('deleteTipo').value = tipo;
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
</body>

</html>