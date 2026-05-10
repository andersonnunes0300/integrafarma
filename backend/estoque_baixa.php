<?php
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_medicamento'];
    $baixa = $_POST['quantidade'];

    if (empty($baixa) || $baixa <= 0) {
        echo "<script>alert('Quantidade inválida!'); window.location.href='../frontend/tela_usuario.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("
        UPDATE medicamentos
        SET quantidade = quantidade - ?
        WHERE id_medicamento = ? AND quantidade >= ?
    ");

    $stmt->bind_param("isi", $baixa, $id, $baixa);

    if ($stmt->execute()) {
        echo "<script>alert('Baixa realizada!'); window.location.href='../frontend/tela_usuario.php';</script>";
    } else {
        echo "Erro ao dar baixa!" . $conn->error;
    }
}
?>