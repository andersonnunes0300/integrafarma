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
        $_SESSION['nome'] = $dados['nome'];

        header("Location: ../frontend/menu_escolhas.php");
        exit;

    } else {
        echo "<script>alert('Login ou senha incorretos. Tente novamente.');</script>";
    }
}
?>