<?php
session_start(); // Inicia a sessão
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
    <?php
    // Incluir arquivo de conexão com o banco de dados
    include 'conexao.php';

    // Verifica se o ID da categoria foi passado na URL
    if (isset($_GET['id'])) {
        $categoria_id = $_GET['id'];

        // Consulta para obter as sub-categorias relacionadas à categoria selecionada
        $query = "SELECT * FROM sub_categoria WHERE id_categoria = :categoria_id";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->execute();
        $sub_categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <?php include 'partials/header.php'; ?>

        <?php include 'partials/hero.php'; ?>

        <div class="page-content">
            <div class="container">
                <div class="docs-overview py-5">
                    <div class="row justify-content-center">
                        <h1 class="text-center">Sub-Categorias</h1>
                        <!-- Aqui começa o loop para exibir as sub-categorias -->
                        <?php foreach ($sub_categorias as $sub_categoria) : ?>
                            <div class="col-12 col-lg-4 py-3">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">
                                            <span class="theme-icon-holder card-icon-holder me-2">
                                                <i class="<?php echo $sub_categoria['icone']; ?>"></i>
                                            </span><!--//card-icon-holder-->
                                            <span class="card-title-text"><?php echo $sub_categoria['nome']; ?></span>
                                        </h5>
                                        <div class="card-text">
                                            <?php echo $sub_categoria['descricao']; ?>
                                        </div>
                                        <a class="card-link-mask" href="lista_links.php?sub_categoria_id=<?php echo $sub_categoria['id_sub_categoria']; ?>"></a>
                                    </div><!--//card-body-->
                                </div><!--//card-->
                            </div><!--//col-->
                        <?php endforeach; ?>
                        <!-- Aqui termina o loop -->
                    </div><!--//row-->
                </div><!--//container-->
            </div><!--//container-->
        </div><!--//page-content-->

        <?php include 'partials/community.php'; ?>

        <?php include 'partials/footer.php'; ?>
    <?php
    } else {
        // Caso nenhum ID de categoria seja passado, exiba uma mensagem de erro ou redirecione para uma página de erro
        echo "Erro: Categoria não especificada";
    }
    ?>

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