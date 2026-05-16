<?php
session_start();
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $nivel = $_POST['nivel'];

    $stmt = $conn->prepare("
     UPDATE usuarios SET nome = ?, login = ?, nivel = ? WHERE id_usuario = ?");

    $stmt->bind_param("sssi", $nome, $login, $nivel, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Usuário atualizado com sucesso!'); window.location.href='../frontend/tela_admin.php';</script>";
    } else {
        echo "Erro ao atualizar o usuário: " . $conn->error;
    }
}
