<?php
session_start();
require_once '../conexao/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: tela_login.php");
    exit;
}

if ($_SESSION['usuario_nivel'] !== 'admin') {
    echo "<script>
            alert('Acesso negado! Esta área é exclusiva para administradores.');
            window.location.href = 'menu_escolhas.php';
          </script>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listas - IntegraFarma</title>
    <link rel="stylesheet" href="../css/listas_users_fornecedores.css">
</head>

<body>
    <div class="container">
        <h2>Gerenciamento de Fornecedores</h2>
        <a href="fornecedor_cad.php" class="btn">➕ Novo Fornecedor</a>

        <table border="1" style="width:100%; margin-top:20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empresa</th>
                    <th>CNPJ</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlF = "SELECT * FROM fornecedores ORDER BY nome_empresa ASC";
                $resF = $conn->query($sqlF);
                while ($f = $resF->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$f['id_fornecedor']}</td>";
                    echo "<td>" . htmlspecialchars($f['nome_empresa']) . "</td>";
                    echo "<td>" . htmlspecialchars($f['cnpj']) . "</td>";
                    echo "<td>
                            <a href='fornecedor_editar.php?id={$f['id_fornecedor']}'>✏️ Editar</a> |
                            <a href='../backend/fornecedor_delete.php?id={$f['id_fornecedor']}' onclick='return confirm(\"Excluir?\")'>🗑️ Excluir</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <hr style="margin: 40px 0;">

        <h2>Gerenciamento de Usuários</h2>
        <a href="usuario_cad.php" class="btn">➕ Novo Usuário</a>
        <table border="1" style="width:100%; margin-top:20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>Nível</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlU = "SELECT * FROM usuarios ORDER BY nome ASC";
                $resU = $conn->query($sqlU);
                while ($u = $resU->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$u['id_usuario']}</td>";
                    echo "<td>" . htmlspecialchars($u['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($u['login']) . "</td>";
                    echo "<td>" . htmlspecialchars($u['nivel']) . "</td>";
                    echo "<td>
                            <a href='usuario_editar.php?id={$u['id_usuario']}'>✏️ Editar</a> |
                            <a href='../backend/usuario_delete.php?id={$u['id_usuario']}' onclick='return confirm(\"Excluir?\")'>🗑️ Excluir</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <a href="tela_admin.php">⬅ Voltar ao Painel Principal</a>
    </div>
</body>

</html>