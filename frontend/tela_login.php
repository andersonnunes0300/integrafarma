<?php
session_start();

require_once '../conexao/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha' LIMIT 1";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {

        $dados = $resultado->fetch_assoc();

        $_SESSION['usuario_id'] = $dados['id_usuario'];
        $_SESSION['usuario_login'] = $dados['login'];
        $_SESSION['usuario_nivel'] = $dados['nivel'];

        if ($_SESSION['usuario_nivel'] === 'admin') {
            header("Location: tela_admin.php");
        } else {
            header("Location: tela_usuario.php");
        }
        exit;
    } else {
        echo "<script>alert('Login ou senha incorretos. Tente novamente.');</script>";
    }
}
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
                    <select name="item-escolha" id="nivel-acesso">
                        <option value="gerente">Funcionário</option>
                        <option value="funcionario">Admin</option>
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