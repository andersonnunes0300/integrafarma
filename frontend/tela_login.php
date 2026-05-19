<?php
session_start();
?>


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

            <form class="form-login" action="../backend/login.php" method="POST">
                <h2>Login Integra Farma</h2>

                <!-- Usuário de Login -->
                <label for="Nome" class="form-label">Usuário de Login:</label>
                <input type="Nome" name="login" class="form-control" id="Nome" placeholder="Login" required>

                <!-- Senha -->
                <label for="inputSenha" class="form-label">Senha:</label>
                <input type="password" name="senha" class="form-control" id="inputSenha" placeholder="Digite sua senha" required>
                
                <div class="nivel">
                    <p class="texto">Nível de Acesso:</p>
                    <select name="nivel" id="nivel-acesso">
                        <option value="funcionario">Funcionário</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Botão entrar -->
                <button type="submit" class="btn-entrar">Entrar</button>
            </form>


        </div>
    </div>
</body>

</html>

</html>