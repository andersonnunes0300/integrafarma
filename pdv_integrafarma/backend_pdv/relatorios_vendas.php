<?php

header('Content-Type: application/json; charset=utf-8');

require_once '../../conexao/conexao.php';

$inicio = $_GET['inicio'] ?? date('Y-m-d');
$fim    = $_GET['fim'] ?? date('Y-m-d');

$sqlTotal = "SELECT
                COUNT(id_venda) AS total_vendas,
                SUM(valor_total) AS faturamento
            FROM vendas
            WHERE DATE(data_venda)
            BETWEEN ? AND ?";

$stmtT = $conn->prepare($sqlTotal);

$stmtT->bind_param("ss", $inicio, $fim);

$stmtT->execute();

$totais = $stmtT->get_result()->fetch_assoc();

$sqlRank = "SELECT
                m.nome,
                SUM(iv.quantidade) AS qtd,
                SUM(iv.quantidade * iv.preco_unitario)
                    AS valor_total

            FROM itens_vendas iv

            INNER JOIN medicamentos m
                ON iv.id_medicamento = m.id_medicamento

            INNER JOIN vendas v
                ON iv.id_venda = v.id_venda

            WHERE DATE(v.data_venda)
            BETWEEN ? AND ?

            GROUP BY m.id_medicamento

            ORDER BY qtd DESC

            LIMIT 10";

$stmtR = $conn->prepare($sqlRank);

$stmtR->bind_param("ss", $inicio, $fim);

$stmtR->execute();

$ranking = $stmtR
    ->get_result()
    ->fetch_all(MYSQLI_ASSOC);

$sqlPagamento = "SELECT
                    forma_pagamento,
                    COUNT(*) AS total

                FROM vendas

                WHERE DATE(data_venda)
                BETWEEN ? AND ?

                GROUP BY forma_pagamento";

$stmtP = $conn->prepare($sqlPagamento);

$stmtP->bind_param("ss", $inicio, $fim);

$stmtP->execute();

$pagamentos = $stmtP
    ->get_result()
    ->fetch_all(MYSQLI_ASSOC);


$sqlOperadores = "SELECT
                    u.nome,
                    COUNT(v.id_venda) AS vendas,
                    SUM(v.valor_total) AS total

                FROM vendas v

                INNER JOIN usuarios u
                    ON v.id_usuario = u.id_usuario

                WHERE DATE(v.data_venda)
                BETWEEN ? AND ?

                GROUP BY u.id_usuario

                ORDER BY total DESC";

$stmtO = $conn->prepare($sqlOperadores);

$stmtO->bind_param("ss", $inicio, $fim);

$stmtO->execute();

$operadores = $stmtO
    ->get_result()
    ->fetch_all(MYSQLI_ASSOC);


echo json_encode([

    'totais' => [
        'total_vendas' =>
            intval($totais['total_vendas'] ?? 0),

        'faturamento' =>
            floatval($totais['faturamento'] ?? 0)
    ],

    'ranking' => $ranking,

    'pagamentos' => $pagamentos,

    'operadores' => $operadores

], JSON_UNESCAPED_UNICODE);

?>