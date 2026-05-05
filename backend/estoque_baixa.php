<?php
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$id = $_POST['id_medicamento'];
$baixa = $_POST['quantidade'];

$stmt = $conn->prepare("
UPDATE medicamentos
SET quantidade = quantidade - ?
WHERE id_medicamento = ?
");

$stmt->bind_param("is", $baixa, $id);

if ($stmt->execute()) {
echo "<script>alert('Baixa realizada!'); window.location.href='../frontend/xxxxx.php';</script>";
}else{
    echo "Erro ao dar baixa!" . $conn->error;
}
}
?>