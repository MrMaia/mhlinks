<?php
session_start(); // Inicia a sessão

// Incluir arquivo de conexão com o banco de dados
include 'conexao.php';

// Consulta para obter as nove primeiras categorias
$query = "SELECT * FROM categoria LIMIT 9";
$stmt = $conexao->query($query);
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <script defer src="assets/fontawesome/js/all.min.js"></script>

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="assets/css/theme.css">

</head>

<body>
    <!-- Header -->
    <?php include 'partials/header.php'; ?>

    <!-- Search Bar -->
    <?php include 'partials/hero.php'; ?>

    <div class="page-content">
        <div class="container">
            <div class="docs-overview py-5">
                <div class="row justify-content-center">
                    <h1 class="text-center">Categorias</h1>
                    <a href="all_categories.php" class="text-center">Ver mais ></a>
                    <?php
                    // Define a função para criar uma categoria com base nos parâmetros fornecidos
                    function createCategoryCard($categoryID, $iconClass, $title, $description, $hasSubcategories) {
                        echo '<div class="col-12 col-lg-4 py-3">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">
                                            <span class="theme-icon-holder card-icon-holder me-2">
                                                <i class="' . $iconClass . '"></i>
                                            </span><!--//card-icon-holder-->
                                            <span class="card-title-text">' . $title . '</span>
                                        </h5>
                                        <div class="card-text">' . $description . '</div>';
                        // Verifica se a categoria tem subcategorias
                        if ($hasSubcategories) {
                            echo '<a class="card-link-mask" href="sub_categorias.php?id=' . $categoryID . '"></a>';
                        } else {
                            echo '<a class="card-link-mask" href="lista_links.php?id=' . $categoryID . '"></a>';
                        }                        
                        echo '</div><!--//card-body-->
                            </div><!--//card-->
                        </div><!--//col-->';
                    }

                    // Exemplo de criação de categoria - Substitua os valores pelos seus dados reais
                    foreach ($categorias as $categoria) {
                        // Verifica se a categoria possui subcategorias
                        $query_sub = "SELECT COUNT(*) AS total FROM sub_categoria WHERE id_categoria = :categoria_id";
                        $stmt_sub = $conexao->prepare($query_sub);
                        $stmt_sub->bindParam(':categoria_id', $categoria['id_categoria']);
                        $stmt_sub->execute();
                        $total_subcategorias = $stmt_sub->fetch(PDO::FETCH_ASSOC)['total'];
                        createCategoryCard($categoria['id_categoria'], $categoria['icone'], $categoria['nome_categoria'], $categoria['descricao'], $total_subcategorias > 0);
                    }
                    ?>
                </div><!--//row-->
            </div><!--//container-->
        </div><!--//container-->
    </div><!--//page-content-->

    <!-- Community Area -->
    <?php include 'partials/community.php'; ?>

    <!-- Footer -->
    <?php include 'partials/footer.php'; ?>

    <!-- Javascript -->
    <script src="assets/plugins/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Page Specific JS -->
    <script src="assets/plugins/smoothscroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/highlight.min.js"></script>
    <script src="assets/js/highlight-custom.js"></script>
    <script src="assets/plugins/simplelightbox/simple-lightbox.min.js"></script>
    <script src="assets/plugins/gumshoe/gumshoe.polyfills.min.js"></script>
    <script src="assets/js/docs.js"></script>

</body>

</html>
