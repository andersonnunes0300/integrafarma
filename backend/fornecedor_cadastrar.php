<?php
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome_empresa'];
    $cnpj = $_POST['cnpj'];

    try {
        $stmt = $conn->prepare("INSERT INTO fornecedores (nome_empresa, cnpj) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $cnpj);

        if ($stmt->execute()) {
            echo "<script>alert('Fornecedor cadastrado com sucesso!'); window.location.href='../frontend/xxxxx.php';</script>";
        }
    } catch (mysqli_sql_exception $e) {

        if ($e->getCode() == 1062) {
            echo "<script>alert('Erro: Este CNPJ já está cadastrado!'); window.location.href='../frontend/xxxxxx.php';</script>";
        } else {
            echo "<script>alert('Erro no banco: " . $e->getMessage() . "'); window.location.href='../frontend/xxxxxx.php';</script>";
        }
    }
}
?>