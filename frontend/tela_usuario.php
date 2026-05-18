<?php
session_start();

require_once '../conexao/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: tela_login.php");
    exit;
}

$pesquisa = isset($_GET['busca']) ? trim($_GET['busca']) : '';
?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tela_usuario.css">
    <title>IntegraFarma - Cadastro</title>
</head>

<body>
    <header>
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <img src="../img/integrafarma.png" alt="Logo Integra Farma">
            </div>

            <div class="info-usuario">
                <span class="icon-nome-usuario">👤 <?= htmlspecialchars($_SESSION['usuario_login']) ?></span>
                <a href="historico.php" class="btn-historico">📜 Relatório</a>
                <a href="../backend/logout.php">Sair</a>
            </div>
        </div>
    </header>

    <main class="conteudo_principal">
        <section id="cadastro_produtos">
            <form action="../backend/estoque_add.php" method="POST">
                <fieldset>
                    <legend>Registrar Medicamento</legend>

                    <div class="campo-grupo">
                        <label for="id_medicamento">Código (ID):</label>
                        <input type="text" id="id_medicamento" name="id_medicamento" required placeholder="DIP-123456">
                    </div>

                    <div class="campo-grupo">
                        <label for="nome">Nome do Medicamento:</label>
                        <input type="text" id="nome" name="nome" required placeholder="Ex: Dipirona 500mg">
                    </div>

                    <div class="campo-grupo">
                        <label for="tipo">Tipo:</label>
                        <input type="text" id="tipo" name="tipo" required placeholder="Ex: Genérico">
                    </div>

                    <div class="campo-grupo">
                        <label for="tarja">Tarja:</label>
                        <input type="text" id="tarja" name="tarja" required placeholder="Ex: Tarja Vermelha">
                    </div>

                    <div class="campo-grupo">
                        <label for="lote">Lote:</label>
                        <input type="text" id="lote" name="lote" placeholder="Ex: L-123456">
                    </div>

                    <div class="campo-grupo">
                        <label for="validade">Data de Validade:</label>
                        <input type="date" id="validade" name="validade">
                    </div>

                    <div class="campo-grupo">
                        <label for="quantidade">Qtd em Estoque:</label>
                        <input type="number" id="quantidade" name="quantidade" min="0" value="0">
                    </div>

                    <div class="campo-grupo">
                        <label for="preco">Preço (R$):</label>
                        <input type="number" id="preco" name="preco" step="0.01" min="0" placeholder="0,00">
                    </div>

                    <div class="campo-grupo">
                        <label for="id_fornecedor">Fornecedor:</label>
                        <select id="id_fornecedor" name="id_fornecedor" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                            <option value="">Selecione um fornecedor</option>
                            <?php
                            $sql_f = "SELECT id_fornecedor, nome_empresa FROM fornecedores ORDER BY nome_empresa ASC";
                            $res_f = $conn->query($sql_f);
                            while ($f = $res_f->fetch_assoc()) {
                                echo "<option value='{$f['id_fornecedor']}'>({$f['id_fornecedor']}) " . htmlspecialchars($f['nome_empresa']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </fieldset>

                <button class="btn-cadastrar" type="submit">Cadastrar Produto</button>
            </form>
        </section>

        <section id="resultado_cadastro">

            <div class="container-busca" style="margin-bottom: 10px; display: flex; justify-content: center; gap: 10px;background-color: #f4f7f6">
                <form action="" method="GET" style="display: flex; width: 400px; gap: 10px; flex-direction: row; background: none; box-shadow: none; padding: 0;">
                    <input type="text" name="busca" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="Pesquise por nome, ID ou tipo..." style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 0.95rem;">
                    <button type="submit" style="padding: 10px 20px; background-color: #28959E; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Buscar</button>

                    <?php if ($pesquisa !== ''): ?>
                        <a href="?" style="padding: 10px 15px; background-color: #e74c3c; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; display: flex; align-items: center; justify-content: center;">Limpar</a>
                    <?php endif; ?>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Tarja</th>
                        <th>Lote</th>
                        <th>Validade</th>
                        <th>Qtd</th>
                        <th>Preço</th>
                        <th>Fornecedor</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT m.*, f.nome_empresa 
                            FROM medicamentos m 
                            LEFT JOIN fornecedores f ON m.id_fornecedor = f.id_fornecedor";

                    // Se houver pesquisa, adiciona filtros preventivos usando o operador LIKE
                    if ($pesquisa !== '') {
                        // Escapa a string para evitar injeções SQL indesejadas
                        $busca_segura = $conn->real_escape_string($pesquisa);
                        $sql .= " WHERE m.nome LIKE '%$busca_segura%'
                                   OR m.id_medicamento LIKE '%$busca_segura%'
                                   OR m.tipo LIKE '%$busca_segura%'";
                    }

                    $sql .= " ORDER BY m.nome ASC";
                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_medicamento']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tarja']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['lote']) . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['validade'])) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantidade']) . "</td>";
                            echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";

                            $nome_f = $row['nome_empresa'] ? htmlspecialchars($row['nome_empresa']) : "Não definido";
                            echo "<td>(" . htmlspecialchars($row['id_fornecedor']) . ") " . $nome_f . "</td>";

                            echo "<td style='text-align: center;'>
                                    <a href='../frontend/estoque_editar.php?id=" . $row['id_medicamento'] . "' title='Editar'>✏️</a>
                                    <a href='../frontend/estoque_baixa.php?id=" . $row['id_medicamento'] . "' title='Dar Baixa' style='margin: 0 8px; color: #e67e22;'>📦↓</a> 
                                    <a href='../backend/estoque_delete.php?id=" . $row['id_medicamento'] . "' onclick=\"return confirm('Deseja excluir?')\" title='Excluir'>🗑️</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' style='text-align:center;'>Nenhum produto encontrado no estoque.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>