<?php
session_start();
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $nivel = $_POST['nivel_acesso'];

    $stmt = $conn->prepare("
    UPDATE usuarios SET nome = ?, login = ?, nivel = ? WHERE id_usuario = ?");

    $stmt->bind_param("sssi", $nome, $login, $nivel, $id);

    if ($stmt->execute()) {
        $id_usuario_logado = $_SESSION['usuario_id'];
        $texto_acao = "Editou o perfil do usuário: " . $login;

        registrarLog($conn, $id_usuario_logado, $texto_acao);


        echo "<script>alert('Usuário atualizado com sucesso!'); window.location.href='../frontend/listas_users_fornecedores.php';</script>";
    } else {
        echo "Erro ao atualizar o usuário: " . $conn->error;
    }
}
