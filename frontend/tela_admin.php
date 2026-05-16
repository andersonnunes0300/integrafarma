<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: tela_login.php");
    exit;
}

require_once '../conexao/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tela_admin.css">
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
                <a href="../backend/logout.php">Sair</a>
            </div>
        </div>
    </header>

    <nav class="menu-adm">
        <ul class="menu-principal">
            <li class="menu-item">
                <a href="listas_users_fornecedores.php" class="link-principal">Fornecedores</a>
                <ul class="submenu">
                    
                </ul>
            </li>

            <li class="menu-item">
                <a href="listas_users_fornecedores.php" class="link-principal">Usuários</a>
                <ul class="submenu">
                    
                </ul>
            </li>

            <li class="menu-item">
                <a href="#" class="link-principal">Estoque</a>
                <ul class="submenu">
                    <li><a href="tela_usuario.php">Cadastrar Produto</a></li>
                    <li><a href="estoque_atualizar.php">Entrada/Saída</a></li>
                    <li><a href="estoque_alertas.php">Alertas de Mínimo</a></li>
                </ul>
            </li>
        </ul>
    </nav>


</body>

</html>