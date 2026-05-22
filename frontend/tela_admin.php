<?php
session_start();
require_once("../conexao/conexao.php");

// Proteção de acesso
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../frontend/tela_login.php");
    exit;
}

if ($_SESSION['usuario_nivel'] !== 'admin') {
    echo "<script>
            alert('Acesso negado! Esta área é exclusiva para administradores.');
            window.location.href = 'menu_escolhas.php';
          </script>";
    exit;
}

$nome_operador = isset($_SESSION['usuario_login']) ? $_SESSION['usuario_login'] : 'Admin';

// Função para verificar status e retornar a recomendação textual
function obterRecomendacaoValidade(string $validade)
{
    $hoje = new DateTime('today');
    $data_validade = new DateTime($validade);
    $intervalo = $hoje->diff($data_validade);
    $diasRestantes = (int)$intervalo->format("%r%a");

    if ($data_validade < $hoje) {
        return [
            'classe' => 'expirado',
            'status' => 'VENCIDO',
            'acao' => '🚫 RETIRAR DO ESTOQUE'
        ];
    } elseif ($diasRestantes <= 30) {
        return [
            'classe' => 'vencendo',
            'status' => "VENCE EM $diasRestantes DIAS",
            'acao' => '⚠️ OFERECER DESCONTO NO PDV'
        ];
    }
    return null;
}

// Busca os medicamentos para o monitoramento
$query = "SELECT id_medicamento, nome, validade FROM medicamentos ORDER BY validade ASC";
$resultado = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integra Farma - Painel Administrativo</title>
    <link rel="stylesheet" href="../css/tela_admin.css">
    <style>
        /* Ajuste para o texto de recomendação não quebrar o layout */
        .texto-recomendacao {
            font-weight: bold;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .linha-expirado .texto-recomendacao {
            color: #d32f2f;
        }

        .linha-vencendo .texto-recomendacao {
            color: #f57c00;
        }

        .tabela-alertas-container {
            margin-top: 20px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <header class="header-admin">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; max-width: 1200px; margin: 0 auto;">
            <img src="../img/integrafarma.png" alt="Logo" style="height: 50px;">
            <div class="info-usuario">
                <span>👤 Operador: <strong><?= htmlspecialchars($nome_operador) ?></strong></span>
                <a href="../frontend/menu_escolhas.php" class="btn-voltar">⬅ Voltar</a>
                <a href="../backend/logout.php" class="btn-sair">Sair</a>
            </div>
        </div>
    </header>

    <main class="dashboard-container">
        <div class="welcome-msg">
            <h1>Painel de Controle Administrativo</h1>
        </div>

        <div class="card-grid">
            <a href="listas_users_fornecedores.php" class="action-card">
                <span class="card-icon">👥</span>
                <h3>Gestão de Pessoas</h3>
                <p>Gerenciar fornecedores e usuários.</p>
            </a>
            <a href="tela_usuario.php" class="action-card">
                <span class="card-icon">📦</span>
                <h3>Cadastrar Produto</h3>
                <p>Adicionar novos medicamentos.</p>
            </a>
            <a href="historico.php" class="action-card">
                <span class="card-icon">🔄</span>
                <h3>Histórico Geral</h3>
                <p>Relatórios de atividades do sistema.</p>
            </a>
            <a href="../pdv_integrafarma/frontend_pdv/relatorios.php" class="action-card">
                <span class="card-icon">📊</span>
                <h3>Relatórios de Vendas</h3>
                <p>Visualizar desempenho e balanços.</p>
            </a>
        </div>

        <section class="monitoramento-validade" style="margin-top: 40px;">
            <h2>⚠️ Alertas de Validade</h2>
            <div class="tabela-alertas-container">
                <table class="tabela-alertas">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Validade</th>
                            <th>Status</th>
                            <th>Recomendação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $alertasExibidos = 0;
                        if ($resultado && $resultado->num_rows > 0):
                            while ($row = $resultado->fetch_assoc()):
                                $info = obterRecomendacaoValidade($row['validade']);
                                if ($info !== null):
                                    $alertasExibidos++;
                        ?>
                                    <tr class="linha-<?= $info['classe'] ?>">
                                        <td><strong><?= htmlspecialchars($row['nome']) ?></strong></td>
                                        <td><?= date('d/m/Y', strtotime($row['validade'])) ?></td>
                                        <td>
                                            <span class="badge-status <?= $info['classe'] ?>">
                                                <?= $info['status'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="texto-recomendacao">
                                                <?= $info['acao'] ?>
                                            </span>
                                        </td>
                                    </tr>
                            <?php
                                endif;
                            endwhile;
                        endif;

                        if ($alertasExibidos === 0): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px;">
                                    ✅ Tudo certo! Nenhum medicamento com validade crítica.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

</body>

</html>