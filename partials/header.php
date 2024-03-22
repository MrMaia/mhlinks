<?php if (!session_id()) session_start(); ?>
<header class="header fixed-top">
    <div class="branding docs-branding">
        <div class="container-fluid position-relative py-2">
            <div class="docs-logo-wrapper">
                <div class="site-logo"><a class="navbar-brand" href="../../index.php"><img class="logo-icon me-2" src="../../assets/images/coderdocs-logo.svg" alt="logo"><span class="logo-text">Ajuda<span class="text-alt">Qui</span></span></a></div>
            </div>
            <div class="docs-top-utilities d-flex justify-content-end align-items-center">
                <ul class="social-list list-inline mx-md-3 mx-lg-5 mb-0 d-none d-lg-flex">
                    <li class="list-inline-item"><a href="https://github.com/MrMaia" target="_blank"><i class="fab fa-github fa-fw"></i></a></li>
                    <li class="list-inline-item"><a href="https://www.instagram.com/allan.maia.92/" target="_blank"><i class="fab fa-instagram fa-fw"></i></a></li>
                    <li class="list-inline-item"><a href="https://discord.gg/JQCwFgHS4F" target="_blank"><i class="fa-brands fa-discord fa-fw"></i></a></li>
                </ul>
                <div class="d-flex flex-row gap-3">
                    <a href="#" class="btn btn-primary d-none d-lg-flex position-relative">
                        Comunidade
                        <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger">
                            EM BREVE
                        </span>
                    </a>
                    <?php if (isset($_SESSION['usuario_id'])) : ?>
                        <!-- Botão de Perfil (opcional) -->
                        <div class="dropdown text-end justify-content-center">
                            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://github.com/mdo.png" alt="mdo" width="36" height="36" class="rounded-circle">
                            </a>
                            <ul class="dropdown-menu text-small">
                                <li><a class="dropdown-item" href="#">Perfil</a></li>
                                <li><a class="dropdown-item" href="#">Comunidade <span class="badge rounded-pill bg-danger text-white">
                            EM BREVE</span></a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../pages\singup\logout.php">Sair</a></li>
                            </ul>
                        </div>
                    <?php else : ?>
                        <a href="../pages\singup\login.php" class="btn btn-primary d-none d-lg-flex">Entrar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</header>