<?php
session_start();
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome_empresa'];
    $cnpj = $_POST['cnpj'];

    $sql = "UPDATE fornecedores SET nome_empresa = ?, cnpj = ? WHERE id_fornecedor = ?";
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("ssi", $nome, $cnpj, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Fornecedor atualizado!'); window.location.href='../frontend/tela_admin.php';</script>";
    } else {
        echo "Erro ao atualizar fornecedor: " . $conn->error;
    }
}
?>