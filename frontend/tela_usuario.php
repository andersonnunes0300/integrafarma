<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: tela_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tela_usuario.css">
    <title>IntegraFarma</title>
</head>

<body>
    <header>
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <img src="../img/integrafarma.png" alt="Logo Integra Farma">
            </div>

            <div class="info-usuario">
                <span class="icon-nome-usuario">👤 <?= htmlspecialchars($_SESSION['nome']) ?></span>
                <a href="historico.php" class="btn-historico">📜 Relatório</a>
                <a href="../backend/logout.php">Sair</a>
            </div>
        </div>
    </header>

    <main class="conteudo_principal">
        <section id="cadastro_produtos">

            <form action="../backend/estoque_add.php" method="POST">
                <!-- Campos do formulário -->
                <fieldset>
                    <legend>Registrar Medicamento</legend>

                    <label for="id_medicamento">Código (ID):</label>
                    <input type="text" id="id_medicamento" name="id_medicamento" maxlength="10" required placeholder="DIP-123456">

                    <label for="nome">Nome do Medicamento:</label>
                    <input type="text" id="nome" name="nome" maxlength="100" required placeholder="Ex: Dipirona 500mg">

                    <label for="tipo">Tipo:</label>
                    <input type="text" id="tipo" name="tipo" required placeholder="Ex: Genérico">

                    <label for="tarja">Tarja:</label>
                    <input type="text" id="tarja" name="tarja" required placeholder="Ex: Tarja Vermelha">

                    <label for="lote">Lote:</label>
                    <input type="text" id="lote" name="lote" placeholder="Ex: L-123456">

                    <label for="validade">Data de Validade:</label>
                    <input type="date" id="validade" name="validade">

                    <label for="quantidade">Quantidade em Estoque:</label>
                    <input type="number" id="quantidade" name="quantidade" min="0" value="0">

                    <label for="preco">Preço (R$):</label>
                    <input type="number" id="preco" name="preco" step="0.01" min="0" placeholder="0,00">

                    <label for="id_fornecedor">ID Fornecedor:</label>
                    <input type="number" id="id_fornecedor" name="id_fornecedor">
                </fieldset>

                <button class="btn-cadastrar" type="submit">Cadastrar</button>
            </form>
        </section>

        <section id="resultado_cadastro">
            <table>
                <thead>
                    <tr>
                        <th>Código (ID)</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Tarja</th>
                        <th>Lote</th>
                        <th>Validade</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>ID Fornecedor</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Aqui serão inseridos os resultados do cadastro -->
                    <?php
                    require_once '../conexao/conexao.php'; // Garante a conexão

                    // Consulta para buscar todos os medicamentos
                    $sql = "SELECT * FROM medicamentos ORDER BY nome ASC";
                    $resultado = $conn->query($sql);

                    if ($resultado->num_rows > 0) {
                        // Loop para exibir cada linha do banco de dados
                        while ($row = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_medicamento']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tarja']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['lote']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['validade']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantidade']) . "</td>";
                            echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
                            echo "<td>" . htmlspecialchars($row['id_fornecedor']) . "</td>";
                            echo "<td style='text-align: center;'>
                    <a href='../backend/estoque_editar.php?id=" . $row['id_medicamento'] . "'>✏️</a>
                    <a href='../backend/estoque_delete.php?id=" . $row['id_medicamento'] . "' onclick=\"return confirm('Deseja excluir?')\">🗑️</a>
                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' style='text-align:center;'>Nenhum produto encontrado no estoque.</td></tr>";
                    }
                    ?>

                </tbody>


        </section>

    </main>

</body>

</html>