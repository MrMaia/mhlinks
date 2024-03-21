<?php
session_start(); // Inicia a sessão no início do arquivo

include '../../conexao.php'; // Substitua pelo caminho correto até seu arquivo conexao.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, senha, is_admin FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Armazena informações do usuário na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nome_usuario'] = $usuario['nome_usuario']; // Nome do usuário
        $_SESSION['is_admin'] = $usuario['is_admin'];
        header("Location: ../../index.php"); // Redireciona para index.php. Ajuste o caminho conforme necessário.
        exit();
    } else {
        $erro_login = "Email ou senha incorretos.";
    }
}
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
    <script defer src="../../assets/fontawesome/js/all.min.js"></script>

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="../../assets/css/theme.css">

</head>

<body>
    <!-- Header -->
    <?php include '../../partials/header.php'; ?>

    <!-- Search Bar -->
    <?php include '../../partials/hero.php'; ?>

    <section class="vh-50">
        <div class="container py-5 h-75">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg" class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <h1 class="text-center">Login</h1>
                    <form method="post">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="email">E-mail</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" required />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="senha">Senha</label>
                            <input type="password" class="form-control form-control-lg" id="senha" name="senha" required />
                        </div>

                        <div class="d-flex justify-content-around align-items-center mb-4">
                            <a href="#!">Esqueceu a senha?</a>
                        </div>

                        <!-- Submit button -->
                        <div class="divider d-flex flex-row justify-content-between my-4">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Entrar</button>
                            </div>
                            <div>
                                <a class="btn btn-primary btn-lg btn-block" href="cadastro.php" role="button">Cadastre-se</a>
                            </div>
                        </div>
                    </form>
                    <?php if (!empty($erro_login)) : ?>
                        <p class="text-danger"><?php echo $erro_login; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Area -->
    <?php include '../../partials/community.php'; ?>

    <!-- Footer -->
    <?php include '../../partials/footer.php'; ?>

    <!-- Javascript -->
    <script src="../../assets/plugins/popper.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Page Specific JS -->
    <script src="../../assets/plugins/smoothscroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/highlight.min.js"></script>
    <script src="../../assets/js/highlight-custom.js"></script>
    <script src="../../assets/plugins/simplelightbox/simple-lightbox.min.js"></script>
    <script src="../../assets/plugins/gumshoe/gumshoe.polyfills.min.js"></script>
    <script src="../../assets/js/docs.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</body>

</html>