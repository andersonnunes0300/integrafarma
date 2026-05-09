
<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>IntegraFarma</title>
</head>

<body>
    <div class="container-login">
        <div class="caixa-login">
            <!-- logo da farmácia  -->
            <img src="../img/integrafarma.png" alt="Logo Integra Farma" class="logo-farmacia">

            <form class="form-login" action="login.php" method="POST">
                <h2>Login Integra Farma</h2>

                <!-- E-mail -->
                <label for="inputEmail" class="form-label">Email:</label>
                <input type="email" name="login" class="form-control" id="inputEmail" placeholder="nome@exemplo.com" required>

                <!-- Senha -->
                <label for="inputSenha" class="form-label">Senha:</label>
                <input type="password" name="senha" class="form-control" id="inputSenha" placeholder="Digite sua senha" required>

                <!-- Botão entrar -->
                <button type="submit" class="btn-entrar">Entrar</button>
            </form>
        </div>
    </div>
</body>

</html>

</html>