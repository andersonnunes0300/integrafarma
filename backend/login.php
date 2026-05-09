<?php
session_start();
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT id_usuario, nome, senha FROM usuarios WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($row = $resultado->fetch_assoc()) {

        if ($senha === $row['senha']) {
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nome'] = $row['nome'];

            header("Location: ../frontend/tela_login.php");
            exit;
        }
    }

    echo "<script>alert('Usuário ou senha incorretos!'); window.location.href='../frontend/tela_login.php';</script>";
}
?>
