<?php
session_start();
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_fornecedor'];
    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];

    $stmt = $conn->prepare("
    UPDATE fornecedores SET nome_empresa = ?, cnpj = ? WHERE id_fornecedor = ?");

    $stmt->bind_param("ssi", $nome, $cnpj, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Fornecedor atualizado!'); window.location.href='../frontend/listas_users_fornecedores.php';</script>";
    } else {
        echo "Erro ao atualizar fornecedor: " . $conn->error;
    }
}
