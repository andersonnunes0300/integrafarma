<?php
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo_cadastro'];

    if ($tipo == 'usuario') {
        $nome = $_POST['nome'];
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $nivel = $_POST['nivel'];

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, login, senha, nivel) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $login, $senha, $nivel);

        if ($stmt->execute()) {
            echo "<script>alert('Usuário criado com sucesso!'); window.location.href='../frontend/xxxxxxx';</script>";
        } else {
            echo "<script>alert('Erro ao criar conta.'); window.location.href='../frontend/xxxxxxxxx';</script>";
        }
    }

}
?>