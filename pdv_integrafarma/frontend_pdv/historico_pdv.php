<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../frontend/tela_login.php");
    exit;
}
$nome_operador = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Operador';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Vendas - Integra Farma</title>
    <link rel="stylesheet" href="../css_pdv/historico_pdv.css">
</head>
<body>

<div class="header-pdv">
    <h2>Integra Farma • Histórico de Vendas</h2>
    <div class="usuario-box">
        <div class="operador">Operador: <strong><?php echo htmlspecialchars($nome_operador); ?></strong></div>
        <a href="tela_pdv.php" class="btn-voltar">⬅ Voltar ao PDV</a>
    </div>
</div>

<div class="container">
    <div class="card">
        <h3>🧾 Registro Geral de Vendas</h3>
        <table id="tabela_historico">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data / Hora</th>
                    <th>Operador</th>
                    <th>Pagamento</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="6" style="text-align:center;">Carregando histórico...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div id="modal_itens" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="fecharModal()">&times;</span>
        <h3 style="color: #1e747c;">📦 Itens da Venda <span id="modal_id_venda"></span></h3>
        <table style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Qtd</th>
                    <th>Preço Un.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="lista_produtos_modal"></tbody>
        </table>
        <p id="vendedor_info" style="color: #1e747c; font-size: 18px; font-weight: 600; margin-top: 20px;"></p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", carregarHistorico);

function carregarHistorico() {
    fetch('../backend_pdv/buscar_historico.php')
    .then(res => res.json())
    .then(data => {
        const tbody = document.querySelector('#tabela_historico tbody');
        tbody.innerHTML = "";
        data.forEach(v => {
            tbody.innerHTML += `
            <tr>
                <td><strong>#${v.id_venda}</strong></td>
                <td>${v.data_venda}</td>
                <td>${v.nome_operador}</td>
                <td>${v.forma_pagamento.toUpperCase()}</td>
                <td><strong style="color: #10b981;">R$ ${v.valor_total.toFixed(2).replace('.', ',')}</strong></td>
                <td><button class="btn-detalhes" onclick="verDetalhes(${v.id_venda})">🔍 Ver Itens</button></td>
            </tr>`;
        });
    });
}

function verDetalhes(idVenda) {
    document.getElementById('modal_id_venda').innerText = "#" + idVenda;
    document.getElementById('modal_itens').style.display = 'block';
    const listaModal = document.getElementById('lista_produtos_modal');
    listaModal.innerHTML = "<tr><td colspan='4'>Carregando itens...</td></tr>";

    fetch(`../backend_pdv/buscar_historico.php?id_venda=${idVenda}`)
    .then(res => res.json())
    .then(res => {
        listaModal.innerHTML = "";
        if (res.itens.length === 0) {
            listaModal.innerHTML = "<tr><td colspan='4'>Nenhum item encontrado.</td></tr>";
            return;
        }
        res.itens.forEach(i => {
            listaModal.innerHTML += `
            <tr>
                <td>${i.nome_medicamento}</td>
                <td>${i.quantidade}x</td>
                <td>R$ ${parseFloat(i.preco_unitario).toFixed(2).replace('.', ',')}</td>
                <td><strong>R$ ${parseFloat(i.subtotal).toFixed(2).replace('.', ',')}</strong></td>
            </tr>`;
        });

        let nivelFormatado = (res.nivel === 'admin') ? 'Administrador' : 'Funcionário';
        document.getElementById('vendedor_info').innerText = `Esta venda foi realizada por: ${res.vendedor} (${nivelFormatado})`;
    });
}

function fecharModal() {
    document.getElementById('modal_itens').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == document.getElementById('modal_itens')) {
        fecharModal();
    }
}
</script>
</body>
</html>