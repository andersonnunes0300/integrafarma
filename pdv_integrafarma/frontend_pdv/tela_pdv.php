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
    <title>PDV - Integra Farma</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css_pdv/tela_pdv.css">
</head>

<body>

    <div class="header-pdv">
        <h2>Integra Farma • Vendas</h2>

        <div class="usuario-box">
            <div class="operador">
                Operador:
                <strong><?php echo htmlspecialchars($nome_operador); ?></strong>
            </div>

            <a href="../../pdv_integrafarma/frontend_pdv/historico_pdv.php" class="btn-nav btn-nav-historico">🧾 Histórico de Vendas</a>
            <a href="../../frontend/menu_escolhas.php" class="btn-voltar">⬅ Voltar</a>
        </div>
    </div>

    <div class="container">

        <div class="card">
            <h3>🛒 Selecionar Medicamento</h3>

            <div class="campo-grupo">
                <label>Pesquisar Produto</label>
                <input
                    type="text"
                    id="buscar_medicamento"
                    list="lista_remedios"
                    placeholder="Digite nome ou ID do medicamento..."
                    autocomplete="off">
                <datalist id="lista_remedios"></datalist>
            </div>

            <div class="linha-campos">
                <div class="campo-grupo">
                    <label>Preço</label>
                    <!-- Atributo data-preco-original adicionado para controle do JS -->
                    <input type="text" id="prod_preco" data-preco-original="" readonly placeholder="R$ 0,00">
                </div>

                <div class="campo-grupo">
                    <label>Estoque</label>
                    <input type="text" id="prod_estoque" readonly placeholder="0">
                </div>

                <div class="campo-grupo">
                    <label>Quantidade</label>
                    <input type="number" id="prod_qtd" min="1" value="1">
                </div>
            </div>

            <!-- Botão de Desconto por Validade Próxima -->
            <button type="button" id="btn_desconto_validade" class="btn-add" style="display: none; background-color: #e67e22; margin-bottom: 10px;">
                ⚠️ Aplicar Desconto de Validade (20%)
            </button>

            <button type="button" id="btn_adicionar" class="btn-add">
                ➕ Adicionar ao Carrinho
            </button>
        </div>

        <div class="card">
            <h3>🧾 Carrinho</h3>

            <div class="table-container">
                <table id="tabela_carrinho">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Medicamento</th>
                            <th>Qtd</th>
                            <th>Preço</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="carrinho_vazio">
                            <td colspan="6" style="text-align:center;color:#9ca3af;">
                                Nenhum produto adicionado.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="campo-grupo" style="margin-top:25px;">
                <label>Forma de Pagamento</label>
                <select id="forma_pagamento">
                    <option value="dinheiro">💵 Dinheiro</option>
                    <option value="pix">📱 PIX</option>
                    <option value="credito">💳 Crédito</option>
                    <option value="debito">💳 Débito</option>
                </select>
            </div>

            <div class="total-box">
                <span>TOTAL DA VENDA</span>
                <h1 id="texto_total">R$ 0,00</h1>
            </div>

            <button type="button" id="btn_finalizar_venda" class="btn-finalizar">
                ✔ Finalizar Venda
            </button>
        </div>

    </div>

    <div class="container container-ultima-venda">
        <div id="area_ultima_venda">
            <h3>✔ Última Venda Realizada com Sucesso!</h3>
            <div class="uv-dados-grupo">
                <p><strong>Data/Hora:</strong> <span id="uv_data"></span></p>
                <p><strong>Forma de Pagamento:</strong> <span id="uv_pagamento"></span></p>
                <p><strong>Vendido por:</strong> <span id="uv_operador"></span></p>
                <p><strong>Total Geral:</strong> <span id="uv_total" class="uv-total-destaque"></span></p>
            </div>
            <div class="uv-lista-container">
                <strong>Produtos Vendidos:</strong>
                <ul id="uv_itens"></ul>
            </div>
        </div>
    </div>

    <script>
        let carrinho = [];
        let totalVenda = 0;
        let todosProdutos = [];
        let precoAtualVenda = 0; // Controla se o preço atual sofreu desconto

        function carregarProdutosDoServidor() {
            fetch('../backend_pdv/buscar_remedio.php')
                .then(res => {
                    if (!res.ok) throw new Error("Erro ao buscar dados do banco (Status: " + res.status + ")");
                    return res.json();
                })
                .then(data => {
                    todosProdutos = data;
                    const datalist = document.getElementById('lista_remedios');
                    datalist.innerHTML = "";

                    data.forEach(p => {
                        let opt = document.createElement('option');
                        opt.value = `${p.id_medicamento} - ${p.nome}`;
                        datalist.appendChild(opt);
                    });
                })
                .catch(err => {
                    console.error("Erro no Fetch do PDV:", err);
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            carregarProdutosDoServidor();
        });

        document.getElementById('buscar_medicamento').addEventListener('input', function(e) {
            let valorInput = e.target.value.trim();
            let id_buscado = valorInput.split(' - ')[0].trim();

            let produto = todosProdutos.find(p =>
                String(p.id_medicamento).trim() === String(id_buscado) ||
                p.nome.toLowerCase() === valorInput.toLowerCase()
            );

            const btnDesconto = document.getElementById('btn_desconto_validade');

            if (produto) {
                precoAtualVenda = parseFloat(produto.preco);
                document.getElementById('prod_preco').value = "R$ " + precoAtualVenda.toFixed(2);
                document.getElementById('prod_preco').setAttribute('data-preco-original', produto.preco);
                document.getElementById('prod_estoque').value = produto.quantidade;

                // VALIDAÇÃO DA VALIDADE: Verifica se o produto tem o campo validade vindo do JSON
                if (produto.data_validade) {
                    let dataValidade = new Date(produto.data_validade);
                    let dataHoje = new Date();

                    // Diferença em dias
                    let diferencaTempo = dataValidade.getTime() - dataHoje.getTime();
                    let diferencaDias = Math.ceil(diferencaTempo / (1000 * 60 * 60 * 24));

                    // Se estiver dentro da validade mas vencer em menos de 30 dias, exibe o botão
                    if (diferencaDias > 0 && diferencaDias <= 30) {
                        btnDesconto.style.display = 'block';
                        btnDesconto.disabled = false;
                        btnDesconto.style.backgroundColor = '#e67e22';
                        btnDesconto.innerText = `⚠️ Aplicar Desconto de Validade (${diferencaDias} dias restantes)`;
                    } else {
                        btnDesconto.style.display = 'none';
                    }
                } else {
                    btnDesconto.style.display = 'none';
                }
            } else {
                document.getElementById('prod_preco').value = "";
                document.getElementById('prod_preco').setAttribute('data-preco-original', "");
                document.getElementById('prod_estoque').value = "";
                btnDesconto.style.display = 'none';
                precoAtualVenda = 0;
            }
        });

        // AÇÃO DO BOTÃO DE DESCONTO
        document.getElementById('btn_desconto_validade').addEventListener('click', function() {
            const inputPreco = document.getElementById('prod_preco');
            let precoOriginal = parseFloat(inputPreco.getAttribute('data-preco-original'));

            if (!isNaN(precoOriginal) && precoOriginal > 0) {
                // Aplica 20% de desconto (Preço original * 0.8)
                precoAtualVenda = precoOriginal * 0.8;
                inputPreco.value = "R$ " + precoAtualVenda.toFixed(2);

                // Estiliza o botão para indicar sucesso
                this.style.backgroundColor = '#2ecc71';
                this.innerText = "✓ Desconto de 20% Aplicado!";
                this.disabled = true;
            }
        });

        document.getElementById('btn_adicionar').addEventListener('click', function() {
            let inputBusca = document.getElementById('buscar_medicamento').value.trim();
            let id_buscado = inputBusca.split(' - ')[0].trim();
            let qtd = parseInt(document.getElementById('prod_qtd').value);

            let produto = todosProdutos.find(p =>
                String(p.id_medicamento).trim() === String(id_buscado) ||
                p.nome.toLowerCase() === inputBusca.toLowerCase()
            );

            if (!produto || qtd <= 0 || isNaN(qtd)) {
                alert("Verifique o produto e a quantidade!");
                return;
            }

            if (qtd > parseInt(produto.quantidade)) {
                alert(`Sem estoque! Máximo: ${produto.quantidade}`);
                return;
            }

            // Usamos o precoAtualVenda que foi definido no input (com ou sem desconto)
            let precoFinalDoItem = precoAtualVenda;

            let itemExistente = carrinho.find(i => String(i.id_medicamento) === String(produto.id_medicamento) && i.preco === precoFinalDoItem);

            if (itemExistente) {
                if ((itemExistente.quantidade + qtd) > produto.quantidade) {
                    alert("Estoque insuficiente!");
                    return;
                }
                itemExistente.quantidade += qtd;
                itemExistente.subtotal = itemExistente.quantidade * itemExistente.preco;
            } else {
                carrinho.push({
                    id_medicamento: produto.id_medicamento,
                    nome: produto.nome,
                    quantidade: qtd,
                    preco: precoFinalDoItem,
                    subtotal: qtd * precoFinalDoItem
                });
            }

            atualizarTabela();

            document.getElementById('buscar_medicamento').value = "";
            document.getElementById('prod_preco').value = "";
            document.getElementById('prod_preco').setAttribute('data-preco-original', "");
            document.getElementById('prod_estoque').value = "";
            document.getElementById('prod_qtd').value = "1";
            document.getElementById('btn_desconto_validade').style.display = 'none';
        });

        function atualizarTabela() {
            const tbody = document.querySelector('#tabela_carrinho tbody');
            tbody.innerHTML = "";

            if (carrinho.length === 0) {
                tbody.innerHTML =
                    `<tr>
            <td colspan="6" style="text-align:center;color:#9ca3af;">
                Nenhum produto adicionado.
            </td>
        </tr>`;
                document.getElementById('texto_total').innerText = "R$ 0,00";
                return;
            }

            totalVenda = 0;

            carrinho.forEach((item, index) => {
                totalVenda += item.subtotal;
                tbody.innerHTML += `
        <tr>
            <td>${item.id_medicamento}</td>
            <td><strong>${item.nome}</strong></td>
            <td>${item.quantidade}</td>
            <td>R$ ${item.preco.toFixed(2)}</td>
            <td><strong>R$ ${item.subtotal.toFixed(2)}</strong></td>
            <td>
                <button class="btn-remover" onclick="removerItem(${index})">✖</button>
            </td>
        </tr>`;
            });

            document.getElementById('texto_total').innerText = "R$ " + totalVenda.toFixed(2);
        }

        function removerItem(index) {
            carrinho.splice(index, 1);
            atualizarTabela();
        }

        document.getElementById('btn_finalizar_venda').addEventListener('click', function() {
            if (carrinho.length === 0) {
                alert("O carrinho está vazio!");
                return;
            }

            if (!confirm("Confirmar venda de R$ " + totalVenda.toFixed(2) + " ?")) return;

            let dadosVenda = {
                forma_pagamento: document.getElementById('forma_pagamento').value,
                valor_total: totalVenda,
                itens: carrinho
            };

            fetch('../backend_pdv/finalizar_venda.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dadosVenda)
                })
                .then(res => res.text())
                .then(texto => {
                    try {
                        let res = JSON.parse(texto);

                        if (res.sucesso) {
                            document.getElementById('uv_data').innerText = new Date().toLocaleString('pt-BR');
                            document.getElementById('uv_pagamento').innerText = res.forma_pagamento;
                            document.getElementById('uv_operador').innerText = res.nome_operador;
                            document.getElementById('uv_total').innerText = "R$ " + parseFloat(res.valor_total).toFixed(2).replace('.', ',');

                            const listaItens = document.getElementById('uv_itens');
                            listaItens.innerHTML = "";
                            carrinho.forEach(item => {
                                listaItens.innerHTML += `<li>📦 <strong>${item.quantidade}x</strong> - ${item.nome} (Preço Un: R$ ${item.preco.toFixed(2)})</li>`;
                            });

                            document.getElementById('area_ultima_venda').style.display = 'block';

                            carrinho = [];
                            totalVenda = 0;
                            atualizarTabela();
                            carregarProdutosDoServidor();

                            alert("Venda realizada com sucesso!");
                        } else {
                            alert("Erro ao finalizar: " + res.mensagem);
                        }
                    } catch (erroJson) {
                        alert("Erro inesperado no servidor. Detalhes: " + texto.substring(0, 150));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Erro na conexão de rede com o servidor.");
                });
        });
    </script>

</body>

</html>