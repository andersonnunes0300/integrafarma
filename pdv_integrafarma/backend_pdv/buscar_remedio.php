<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([]);
    exit;
}

require_once '../../conexao/conexao.php';

$sql = "SELECT id_medicamento, nome, preco, quantidade FROM medicamentos WHERE quantidade > 0";
$resultado = $conn->query($sql);

$produtos = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $produtos[] = [
            'id_medicamento' => $linha['id_medicamento'],
            'nome'           => $linha['nome'],
            'preco'          => floatval($linha['preco']),
            'quantidade'     => intval($linha['quantidade'])
        ];
    }
}

echo json_encode($produtos, JSON_UNESCAPED_UNICODE);
?>