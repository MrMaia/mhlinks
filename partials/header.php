<?php if (!session_id()) session_start(); ?>
<header class="header fixed-top">
    <div class="branding docs-branding">
        <div class="container-fluid position-relative py-2">
            <div class="docs-logo-wrapper">
                <div class="site-logo"><a class="navbar-brand" href="index.php"><img class="logo-icon me-2"
                            src="assets/images/coderdocs-logo.svg" alt="logo"><span class="logo-text">Ajuda<span
                                class="text-alt">Qui</span></span></a></div>
            </div><!--//docs-logo-wrapper-->
            <div class="docs-top-utilities d-flex justify-content-end align-items-center">
                <ul class="social-list list-inline mx-md-3 mx-lg-5 mb-0 d-none d-lg-flex">
                    <li class="list-inline-item"><a href="https://github.com/MrMaia" target="_blank"><i
                                class="fab fa-github fa-fw"></i></a></li>
                    <li class="list-inline-item"><a href="https://www.instagram.com/allan.maia.92/"
                            target="_blank"><i class="fab fa-instagram fa-fw"></i></a></li>
                </ul><!--//social-list-->
                <div class="d-flex flex-row gap-3">
                    <a href="#" class="btn btn-primary d-none d-lg-flex position-relative">
                        Comunidade
                        <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger">
                            EM BREVE
                        </span>
                    </a>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <!-- Botão de Perfil (opcional) -->
                        <a href="perfil.php" class="btn btn-primary d-none d-lg-flex"><i class="fas fa-user"></i></a>
                        <!-- Botão de Logout -->
                        <a href="../pages\singup\logout.php" class="btn btn-danger d-none d-lg-flex">Sair</a>
                    <?php else: ?>
                        <a href="../pages\singup\login.php" class="btn btn-primary d-none d-lg-flex">Entrar</a>
                    <?php endif; ?>
                </div><!--//docs-top-utilities-->
            </div><!--//container-->
        </div><!--//branding-->
    </header><!--//header-->
