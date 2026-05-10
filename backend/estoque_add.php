<?php
session_start();
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id_medicamento'];
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $tarja = $_POST['tarja'];
    $lote = $_POST['lote'];
    $validade = $_POST['validade'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    $fornecedor = $_POST['id_fornecedor'];

    $stmt = $conn->prepare("INSERT INTO medicamentos (id_medicamento, nome, tipo, tarja, lote, validade, quantidade, preco, id_fornecedor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssidi", $id, $nome, $tipo, $tarja, $lote, $validade, $quantidade, $preco, $fornecedor);

    if ($stmt->execute()) {

        header("Location: ../frontend/tela_usuario.php");
        exit(); 
    } else {
        echo "Erro ao Cadastrar: " . $stmt->error;
    }
}
?>