<?php
require_once '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id = $_POST['id_medicamento'];
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];
        $tarja = $_POST['tarja'];
        $lote = $_POST['lote'];
        $validade = $_POST['validade'];
        $quantidade = $_POST['quantidade'];
        $preco = $_POST ['preco'];
        $id_fornecedor = $_POST['id_fornecedor'];

$stmt = $conn->prepare("
UPDATE medicamentos
SET nome=?, tipo=?, tarja=?, lote=?, validade=?, quantidade=?, preco=?, id_fornecedor=?
WHERE id_medicamento=?
");

        $stmt->bind_param("sssssdiss", 
            $nome, 
            $tipo, 
            $tarja, 
            $lote, 
            $validade, 
            $quantidade, 
            $preco, 
            $id_fornecedor, 
            $id
        );

if ($stmt->execute()) {
echo "<script>alert('Medicamento atualizado!'); window.location.href='../frontend/tela_usuario.php';</script>";
}else{
    echo "Erro ao atualizar!" . $conn->error;
}
}
?>