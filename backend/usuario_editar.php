<?php
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $nivel = $_POST['nivel'];


    $sql = "UPDATE usuarios SET nome = ?, login = ?, nivel = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("sssi", $nome, $login, $nivel, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Usuário atualizado com sucesso!'); window.location.href='../frontend/xxxxxxx.php';</script>";
    } else {
        echo "Erro ao atualizar o usuário: " . $conn->error;
    }
}
?>