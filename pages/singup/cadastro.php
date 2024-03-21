<?php
    session_start(); // Inicia a sessão no início do arquivo

    include '../../conexao.php'; // Substitua pelo caminho correto até seu arquivo conexao.php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $nome_usuario = $_POST['nome_usuario'];
        $senha = $_POST['senha'];
        $confirma_senha = $_POST['confirma_senha'];

        // Verifica se as senhas são iguais
        if ($senha != $confirma_senha) {
            // Armazena a mensagem de erro na sessão
            $_SESSION['erro_cadastro'] = "As senhas não coincidem.";
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $is_admin = 0; // Usuário comum

            $sql = "INSERT INTO usuarios (email, nome_usuario, senha, is_admin) VALUES (?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);

            if ($stmt->execute([$email, $nome_usuario, $senha_hash, $is_admin])) {
                // Redireciona para a página de login ou outra página desejada após o cadastro
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['erro_cadastro'] = "Erro ao cadastrar usuário.";
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <title>AjudaQui - Seu site dos links</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="coderdocs-logo.ico">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
        <script defer src="../../assets/fontawesome/js/all.min.js"></script>
        <link id="theme-style" rel="stylesheet" href="../../assets/css/theme.css">
    </head>

    <body>
        <?php include '../../partials/header.php'; ?>
        <?php include '../../partials/hero.php'; ?>
        <section class="vh-50">
            <div class="container py-5 h-100">
                <div class="row d-flex align-items-center justify-content-center h-100">
                    <div class="col-md-8 col-lg-7 col-xl-6">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg" class="img-fluid" alt="Imagem Login">
                    </div>
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        <h1 class="text-center">Cadastro</h1>
                        <form method="post">
                            <div class="form-outline mb-4">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                            </div>

                            <div class="form-outline mb-4">
                                <label for="nome_usuario">Usuário</label>
                                <input type="text" id="nome_usuario" name="nome_usuario" class="form-control form-control-lg" required>
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="senha">Senha</label>
                                <input type="password" id="senha" name="senha" class="form-control form-control-lg" required />
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="confirma_senha">Confirme sua senha</label>
                                <input type="password" id="confirma_senha" name="confirma_senha" class="form-control form-control-lg" required />
                            </div>

                            <div class="divider d-flex justify-content-center my-4">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Cadastrar</button>
                            </div>
                        </form>
                        <?php if (!empty($_SESSION['erro_cadastro'])) : ?>
                            <p class="text-danger"><?php echo $_SESSION['erro_cadastro']; ?></p>
                            <?php unset($_SESSION['erro_cadastro']); // Remove a mensagem de erro da sessão após exibição 
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php include '../../partials/community.php'; ?>
        <?php include '../../partials/footer.php'; ?>

        <script src="../../assets/plugins/popper.min.js"></script>
        <script src="../../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="../../assets/plugins/smoothscroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/highlight.min.js"></script>
    </body>

    </html>