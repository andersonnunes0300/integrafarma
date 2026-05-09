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

    $stmt = $conn->prepare("INSERT INTO medicamentos (id_medicamento,nome,tipo,tarja,lote,validade,quantidade,preco,id_fornecedor)VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssidi", $id, $nome, $tipo, $tarja, $lote, $validade, $quantidade, $preco, $fornecedor);

    if ($stmt->execute()) {
        echo "<!DOCTYPE html><html lang='pt-Br'><head><meta charset='UTF-8'><link rel='stylesheet' href='../css/tela_usuario.css'><title>Sucesso</title></head><body>";
        echo "<div class='container' style='margin-top: 50px;>";
        echo "<h1>✅ Medicamento Cadastrado com Sucesso!</h1>";
        echo "<table class='tabela-resultado'>
            <thead>
                <tr>
                    <th>Campo</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr><td><strong>ID:</strong></td><td>$id</td></tr>
                <tr><td><strong>Nome:</strong></td><td>$nome</td></tr>
                <tr><td><strong>Tipo:</strong></td><td>$tipo</td></tr>
                <tr><td><strong>Tarja:</strong></td><td>$tarja</td></tr>
                <tr><td><strong>Lote:</strong></td><td>$lote</td></tr>
                <tr><td><strong>Validade:</strong></td><td>$validade</td></tr>
                <tr><td><strong>Quantidade:</strong></td><td>$quantidade</td></tr>
                <tr><td><strong>Preço:</strong></td><td>R$ " . number_format($preco, 2, ',', '.') . "</td></tr>
                <tr><td><strong>ID Fornecedor:</strong></td><td>$fornecedor</td></tr>
            </tbody>
          </table>";

        echo "<br><a href='../frontend/tela_usuario.php' class='btn-cadastrar'>Cadastrar Novo</a>";
        echo "</div>";
    } else {
        echo "Erro ao Cadastrar: " . $stmt->error;
    }
}
