<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../frontend/tela_login.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Vendas</title>
    <link rel="stylesheet" href="../css_pdv/relatorios_pdv.css">
</head>
<body>

<div class="container">

    <div class="header-top">
        <h2>Relatório Financeiro</h2>
        <a href="../../frontend/tela_admin.php" class="btn-voltar">⬅ Voltar</a>
    </div>

    <div class="filtro-box">
        <input type="date" id="data_ini" value="<?= date('Y-m-d') ?>">
        <input type="date" id="data_fim" value="<?= date('Y-m-d') ?>">
        <button onclick="carregarDados()" class="btn-filtrar">Atualizar</button>
    </div>

    <div class="stats-container">
        <div class="card-stat">
            <h4>Total de Vendas</h4>
            <p id="total_vendas">0</p>
        </div>

        <div class="card-stat">
            <h4>Faturamento</h4>
            <p id="faturamento">R$ 0,00</p>
        </div>
    </div>

    <div class="card">
        <h3>Medicamentos Mais Vendidos</h3>
        <table>
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Qtd</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="corpo_ranking"></tbody>
        </table>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">

        <div class="card">
            <h3>💳 Pagamentos</h3>
            <table>
                <thead>
                    <tr>
                        <th>Forma</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="corpo_pagamentos"></tbody>
            </table>
        </div>

        <div class="card">
            <h3>👨‍💼 Operadores</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Vendas</th>
                        <th>R$</th>
                    </tr>
                </thead>
                <tbody id="corpo_operadores"></tbody>
            </table>
        </div>

    </div>
</div>

<script>
function carregarDados() {
    const ini = document.getElementById('data_ini').value;
    const fim = document.getElementById('data_fim').value;

    fetch(`../backend_pdv/relatorios_vendas.php?inicio=${ini}&fim=${fim}`)
        .then(r => r.json())
        .then(data => {

            console.log(data);

            document.getElementById('total_vendas').innerText =
                data.totais.total_vendas;

            document.getElementById('faturamento').innerText =
                'R$ ' + parseFloat(data.totais.faturamento)
                .toFixed(2)
                .replace('.', ',');

            let htmlRanking = '';
            data.ranking.forEach(item => {
                htmlRanking += `
                    <tr>
                        <td>${item.nome}</td>
                        <td>${item.qtd}</td>
                        <td>R$ ${parseFloat(item.valor_total).toFixed(2).replace('.', ',')}</td>
                    </tr>
                `;
            });
            document.getElementById('corpo_ranking').innerHTML = htmlRanking;

            let htmlPag = '';
            data.pagamentos.forEach(item => {
                htmlPag += `
                    <tr>
                        <td>${item.forma_pagamento}</td>
                        <td>${item.total}</td>
                    </tr>
                `;
            });
            document.getElementById('corpo_pagamentos').innerHTML = htmlPag;

            let htmlOp = '';
            data.operadores.forEach(item => {
                htmlOp += `
                    <tr>
                        <td>${item.nome}</td>
                        <td>${item.vendas}</td>
                        <td>R$ ${parseFloat(item.total).toFixed(2).replace('.', ',')}</td>
                    </tr>
                `;
            });
            document.getElementById('corpo_operadores').innerHTML = htmlOp;

        })
        .catch(err => {
            console.error("Erro:", err);
            alert("Erro ao carregar relatório");
        });
}

carregarDados();
</script>

</body>
</html>