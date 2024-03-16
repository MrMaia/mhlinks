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
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/hero.php'; ?>
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row justify-content-center mb-3">
                <h1 class="text-center">Resultado da Pesquisa</h1>
                <div class="col-md-12 col-xl-10 gap-5">
                    <div class="card shadow-0 border rounded-3 mb-4">
                        <div class="card-body">
                            <?php
                            // Verifica se foi submetido um formulário de pesquisa
                            if (isset($_GET['search'])) {
                                // Recupera o termo de pesquisa
                                $termo_pesquisa = $_GET['search'];

                                // Conexão com o banco de dados (substitua 'localhost', 'usuario', 'senha', 'nome_do_banco' com suas credenciais)
                                $conexao = new mysqli('localhost', 'root', '', 'ajudaqui');

                                // Verifica erros na conexão
                                if ($conexao->connect_error) {
                                    die("Erro na conexão: " . $conexao->connect_error);
                                }

                                // Consulta SQL para buscar resultados na tabela "link"
                                $query = "SELECT * FROM link WHERE nome LIKE '%$termo_pesquisa%' OR descricao LIKE '%$termo_pesquisa%'";

                                // Executa a consulta
                                $resultado = $conexao->query($query);

                                // Verifica se há resultados
                                if ($resultado->num_rows > 0) {
                                    // Exibe os resultados
                                    while ($row = $resultado->fetch_assoc()) {
                                        echo "<div class='row mb-4'>";
                                        echo "<div class='col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0'>";
                                        echo "<div class='bg-image hover-zoom ripple rounded ripple-surface'>";
                                        echo "<img src='" . $row['imagem'] . "' class='w-100' />";
                                        echo "<a href='" . $row['link'] . "' target='_blank'>";
                                        echo "<div class='hover-overlay'>";
                                        echo "<div class='mask' style='background-color: rgba(253, 253, 253, 0.15);'></div>";
                                        echo "</div>";
                                        echo "</a>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='col-md-6 col-lg-6 col-xl-6'>";
                                        echo "<h5>" . $row['nome'] . "</h5>";
                                        echo "<p class='mb-4 mb-md-0'>" . $row['descricao'] . "</p>";
                                        echo "</div>";
                                        echo "<div class='col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start'>";
                                        echo "<div class='d-flex flex-column mt-4'>";
                                        echo "<a class='btn btn-primary btn-sm' href='" . $row['link'] . "' target='_blank'>Acessar</a>";
                                        echo "<button class='btn btn-outline-primary btn-sm mt-2'>Recomendar Site</button>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<p class='text-center'>Nenhum resultado encontrado para a pesquisa: <strong>$termo_pesquisa</strong>.</p>";
                                }

                                // Fecha a conexão com o banco de dados
                                $conexao->close();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'partials/community.php'; ?>

    <?php include 'partials/footer.php'; ?>
</body>

</html>