<?php
// Incluir arquivo de conexão com o banco de dados
include 'conexao.php';

// Consulta para obter todas as categorias
$query = "SELECT * FROM categoria";
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
    <?php include 'partials/header.php'; ?>

    <div class="page-content">
        <div class="container">
            <div class="docs-overview py-5">
                <div class="row justify-content-center">
                    <h1 class="text-center">Categorias</h1>
                    <div class="col-12">
                        <div class="row">
                            <?php foreach ($categorias as $categoria) : ?>
                                <div class="col-12 col-lg-4 py-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">
                                                <span class="theme-icon-holder card-icon-holder me-2">
                                                    <i class="<?php echo $categoria['icone']; ?>"></i>
                                                </span><!--//card-icon-holder-->
                                                <span class="card-title-text"><?php echo $categoria['nome_categoria']; ?></span>
                                            </h5>
                                            <div class="card-text">
                                                <?php echo $categoria['descricao']; ?>
                                            </div>
                                            <a class="card-link-mask" href="sub_categorias.php?id=<?php echo $categoria['id_categoria']; ?>"></a>
                                        </div><!--//card-body-->
                                    </div><!--//card-->
                                </div><!--//col-->
                            <?php endforeach; ?>
                        </div><!--//row-->
                    </div><!--//col-->
                </div><!--//row-->
            </div><!--//container-->
        </div><!--//container-->
    </div><!--//page-content-->

    <section class="cta-section text-center py-5 theme-bg-dark position-relative">
        <!-- Código do restante da seção CTA -->
    </section><!--//cta-section-->

    <footer class="footer">
        <!-- Código do footer -->
    </footer>

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
