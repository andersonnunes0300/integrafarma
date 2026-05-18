<?php
session_start();
require_once '../conexao/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: tela_login.php");
    exit;
}

$logs = [];
try {
    $query = "SELECT l.id_log, l.acao, l.data_hora, u.nome as nome_usuario
              FROM logs_historico l
              JOIN usuarios u ON l.id_usuario = u.id_usuario
              ORDER BY l.data_hora DESC";

    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
    }
} catch (Exception $e) {
    echo "Erro ao buscar logs: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tela_usuario.css">
    <title>IntegraFarma - Histórico</title>
</head>

<body>
    <header>
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <img src="../img/integrafarma.png" alt="Logo Integra Farma">
            </div>

            <div class="info-usuario">
                <span class="icon-nome-usuario">👤 <?= htmlspecialchars($_SESSION['usuario_login']) ?></span>
                <a href="../backend/logout.php" style="text-decoration: none; color: #e74c3c; font-weight: bold; margin-left: 15px;">Sair</a>
            </div>
        </div>
    </header>

    <main class="info-historico" style="max-width: 1000px; margin: 40px auto; padding: 20px;">
        <h2>Histórico de Atividades</h2>
        <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Ação</th>
                    <th>Data/Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($logs) > 0): ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['id_log']) ?></td>
                            <td><?= htmlspecialchars($log['nome_usuario']) ?></td>
                            <td><?= htmlspecialchars($log['acao']) ?></td>
                            <td><?= htmlspecialchars($log['data_hora']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 15px;">Nenhum registro encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br>
        <a href="tela_usuario.php" class="btn-voltar" style="text-decoration: none; display: inline-block; margin-top: 20px;">← Voltar</a>
    </main>
</body>

</html>