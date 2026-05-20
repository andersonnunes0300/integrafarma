<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

session_start();
require_once '../../conexao/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Sessão expirada.']);
    exit;
}

$id_venda = isset($_GET['id_venda']) ? intval($_GET['id_venda']) : null;

try {
    if ($id_venda) {
        $sql = "SELECT iv.quantidade, iv.preco_unitario, m.nome AS nome_medicamento, 
                       u.nome AS vendedor, u.nivel
                FROM itens_vendas iv
                INNER JOIN medicamentos m ON iv.id_medicamento = m.id_medicamento
                INNER JOIN vendas v ON iv.id_venda = v.id_venda
                INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
                WHERE iv.id_venda = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_venda);
        $stmt->execute();
        $result = $stmt->get_result();

        $itens = [];
        $vendedor = '';
        $nivel = '';

        while ($row = $result->fetch_assoc()) {
            $vendedor = $row['vendedor'];
            $nivel    = $row['nivel'];

            $preco = floatval($row['preco_unitario']);
            $row['preco_unitario'] = $preco;
            $row['subtotal']       = $row['quantidade'] * $preco;

            unset($row['vendedor'], $row['nivel']);
            $itens[] = $row;
        }

        echo json_encode([
            'sucesso'  => true,
            'itens'    => $itens,
            'vendedor' => $vendedor,
            'nivel'    => $nivel
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $sql = "SELECT v.id_venda, v.data_venda, v.valor_total, v.forma_pagamento, u.nome AS nome_operador
            FROM vendas v
            INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
            ORDER BY v.data_venda DESC";

    $result = $conn->query($sql);
    $historico = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row['data_venda']  = date('d/m/Y H:i:s', strtotime($row['data_venda']));
            $row['valor_total'] = floatval($row['valor_total']);
            $historico[] = $row;
        }
    }

    echo json_encode($historico, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode([
        'sucesso' => false,
        'erro'    => $e->getMessage()
    ]);
}
?>