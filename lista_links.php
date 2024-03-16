<?php
session_start(); // Inicia a sessão

// Incluir arquivo de conexão com o banco de dados
include 'conexao.php';

// Verifica se o ID da subcategoria foi passado na URL
if (isset($_GET['sub_categoria_id'])) {
    $sub_categoria_id = $_GET['sub_categoria_id'];

    // Consulta para obter os links relacionados à subcategoria selecionada
    $query = "SELECT * FROM link WHERE id_sub_categoria = :sub_categoria_id";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':sub_categoria_id', $sub_categoria_id);
    $stmt->execute();
    $links = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <!-- Custom JavaScript -->
        <script>
            function openLinkInNewTab(url) {
                // Certifique-se de que a URL começa com http:// ou https:// para ser uma URL válida
                if (!url.startsWith('http://') && !url.startsWith('https://')) {
                    url = 'http://' + url;
                }
                // Abra a URL em uma nova aba
                window.open(url, '_blank');
            }
        </script>
    </head>

    <body>
        <?php include 'partials/header.php'; ?>

        <?php include 'partials/hero.php'; ?>

        <section style="background-color: #eee;">
            <div class="container py-5">
                <div class="row justify-content-center mb-3">
                    <div class="col-md-12 col-xl-10">
                        <?php foreach ($links as $link) : ?>
                            <div class="card shadow-0 border rounded-3 mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                            <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                                <img src="<?php echo $link['imagem']; ?>" class="w-100" />
                                                <a href="<?php echo $link['link']; ?>" target="_blank">
                                                    <div class="hover-overlay">
                                                        <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xl-6">
                                            <h5><?php echo $link['nome']; ?></h5>
                                            <p class="mb-4 mb-md-0"><?php echo $link['descricao']; ?></p>
                                        </div>
                                        <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                                            <div class="d-flex flex-column mt-4">
                                                <button class="btn btn-primary btn-sm" onclick="openLinkInNewTab('<?php echo $link['link']; ?>')">Acessar</button>
                                                <button class="btn btn-outline-primary btn-sm mt-2">Recomendar Site</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php include 'partials/community.php'; ?>

        <?php include 'partials/footer.php'; ?>
    </body>

    </html>
    <?php
} else {
    // Se nenhum ID de subcategoria for passado, consultar os links relacionados à categoria diretamente
    if (isset($_GET['id'])) {
        $categoria_id = $_GET['id'];

        // Consulta para obter os links relacionados à categoria selecionada
        $query = "SELECT * FROM link WHERE id_categoria = :categoria_id AND id_sub_categoria IS NULL";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->execute();
        $links = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Se houver links relacionados à categoria, exibi-los
        if ($links) {
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
                <!-- Custom JavaScript -->
                <script>
                    function openLinkInNewTab(url) {
                        // Certifique-se de que a URL começa com http:// ou https:// para ser uma URL válida
                        if (!url.startsWith('http://') && !url.startsWith('https://')) {
                            url = 'http://' + url;
                        }
                        // Abra a URL em uma nova aba
                        window.open(url, '_blank');
                    }
                </script>
            </head>

            <body>
                <?php include 'partials/header.php'; ?>

                <?php include 'partials/hero.php'; ?>

                <section style="background-color: #eee;">
                    <div class="container py-5">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-12 col-xl-10">
                                <?php foreach ($links as $link) : ?>
                                    <div class="card shadow-0 border rounded-3 mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                                    <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                                        <img src="<?php echo $link['imagem']; ?>" class="w-100" />
                                                        <a href="<?php echo $link['link']; ?>" target="_blank">
                                                            <div class="hover-overlay">
                                                                <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-6 col-xl-6">
                                                    <h5><?php echo $link['nome']; ?></h5>
                                                    <p class="mb-4 mb-md-0"><?php echo $link['descricao']; ?></p>
                                                </div>
                                                <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                                                    <div class="d-flex flex-column mt-4">
                                                        <button class="btn btn-primary btn-sm" onclick="openLinkInNewTab('<?php echo $link['link']; ?>')">Acessar</button>
                                                        <button class="btn btn-outline-primary btn-sm mt-2">Recomendar Site</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </section>

                <?php include 'partials/community.php'; ?>

                <?php include 'partials/footer.php'; ?>
            </body>

            </html>
    <?php
        } else {
            // Se não houver links relacionados à categoria, exibir mensagem de erro
            echo "Erro: Nenhum link encontrado para esta categoria.";
        }
    } else {
        // Caso nenhum ID de categoria seja passado, exibir mensagem de erro ou redirecionar para uma página de erro
        echo "Erro: Categoria não especificada";
    }
}
?>
