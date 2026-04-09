<?php
session_start();
require_once '../conexao/conexao.php';

if (!isset($_GET['id'])) {
    header("Location: ../frontend/xxxxxxx.php");
    exit;
}

$id = $_GET['id'];

if ($id == $_SESSION['id_usuario']) {
    echo "<script>alert('Atenção: Você não pode excluir seu próprio usuário!'); window.location.href='../frontend/xxxxxxxx.php';</script>";
    exit;
}

$sql = "DELETE FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Usuário removido!'); window.location.href='../frontend/xxxxxxxx';</script>";
} else {
    echo "Erro ao excluir usuário: " . $conn->error;
}
?>