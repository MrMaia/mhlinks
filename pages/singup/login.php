<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card my-5">
                <div class="card-body">
                    <h3 class="card-title text-center">Login</h3>
                    <form action="processa_login.php" method="post">
                        <div class="form-group">
                            <label for="username">Nome de usuário</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="register.php">Cadastre-se</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
