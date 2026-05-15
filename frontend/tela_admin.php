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
                <a href="#" class="link-principal">Config. Fornecedor</a>
                <ul class="submenu">
                    <li><a href="fornecedor_cadastrar.php">Cadastrar Fornecedor</a></li>
                    <li><a href="fornecedor_editar.php">Editar Fornecedor</a></li>
                    <li><a href="fornecedor_excluir.php">Excluir Fornecedor</a></li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="#" class="link-principal">Config. Usuário</a>
                <ul class="submenu">
                    <li><a href="usuario_cad.php">Cadastrar Usuário</a></li>
                    <li><a href="usuario_editar.php">Editar Usuário</a></li>
                    <li><a href="usuario_excluir.php">Excluir Usuário</a></li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="#" class="link-principal">Config. Estoque</a>
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