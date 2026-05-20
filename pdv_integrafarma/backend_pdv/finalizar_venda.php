<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');
session_start();


require_once '../../conexao/conexao.php'; 

$id_usuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : (isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null);

if (!$id_usuario) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Sessão expirada. Por favor, faça login novamente.'
    ]);
    exit;
}

$input = file_get_contents('php://input');
$dados = json_decode($input, true);

if (!$dados || empty($dados['itens'])) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'O carrinho de compras está vazio.'
    ]);
    exit;
}

$nome_operador   = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Operador';
$forma_pagamento = $dados['forma_pagamento'];
$valor_total     = floatval($dados['valor_total']);
$itens           = $dados['itens'];

try {
    $conn->begin_transaction();

    $sqlVenda = "INSERT INTO vendas (id_usuario, valor_total, forma_pagamento, data_venda) VALUES (?, ?, ?, NOW())";
    $stmtVenda = $conn->prepare($sqlVenda);
    
    if (!$stmtVenda) {
        throw new Exception("Erro no prepare da Venda: " . $conn->error);
    }
    
    $stmtVenda->bind_param("ids", $id_usuario, $valor_total, $forma_pagamento);
    $stmtVenda->execute();
    
    $id_venda = $conn->insert_id;
    $stmtVenda->close();

    foreach ($itens as $item) {
        $id_medicamento = trim(strval($item['id_medicamento']));
        $quantidade     = intval($item['quantidade']);
        $preco_unitario = floatval($item['preco']);

        $sqlItem = "INSERT INTO itens_vendas (id_venda, id_medicamento, quantidade, preco_unitario) VALUES (?, ?, ?, ?)";
        $stmtItem = $conn->prepare($sqlItem);
        
        if (!$stmtItem) {
            throw new Exception("Erro no prepare do Item: " . $conn->error);
        }
        
        $stmtItem->bind_param("isid", $id_venda, $id_medicamento, $quantidade, $preco_unitario);
        $stmtItem->execute();
        $stmtItem->close();

        $sqlEstoque = "UPDATE medicamentos SET quantidade = quantidade - ? WHERE id_medicamento = ?";
        $stmtEstoque = $conn->prepare($sqlEstoque);
        
        if (!$stmtEstoque) {
            throw new Exception("Erro no prepare do Estoque: " . $conn->error);
        }

        $stmtEstoque->bind_param("is", $quantidade, $id_medicamento);
        $stmtEstoque->execute();
        $stmtEstoque->close();
    }

    $conn->commit();

    echo json_encode([
        'sucesso'         => true,
        'valor_total'     => $valor_total,
        'forma_pagamento' => $forma_pagamento,
        'nome_operador'   => $nome_operador
    ]);

} catch (Exception $e) {
    $conn->rollback();

    echo json_encode([
        'sucesso'  => false,
        'mensagem' => $e->getMessage()
    ]);
}
exit;