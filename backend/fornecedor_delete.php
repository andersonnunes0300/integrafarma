<?php
require_once '../conexao/conexao.php';

$id = $_GET['id'];

$sql = "DELETE FROM fornecedores WHERE id_fornecedor = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

try {
    $stmt->execute();
    header("Location: ../frontend/listas_users_fornecedores.php?msg=sucesso");
} catch (Exception $e) {

    echo "<script>alert('Erro: Este fornecedor possui medicamentos cadastrados e não pode ser removido.');
          window.location.href='../frontend/listas_users_fornecedores.php';</script>";
}
?>