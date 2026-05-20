<?php
session_start();

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
    <title>Cadastro de Forncedor - Integra Farma</title>
    <link rel="stylesheet" href="../css/fornecedor_cad.css">
</head>

<body>
    <div class="card">
        <h2>Cadastrar Fornecedor</h2>
        <form action="../backend/fornecedor_cadastrar.php" method="POST">
            <input type="hidden" name="tipo_cadastro" value="fornecedor">

            <input type="text" name="nome_empresa" placeholder="Nome do Fornecedor" required>
            <input type="text" name="cnpj" placeholder="CNPJ" required>

            <div class="botoes-form">
                <button type="reset" class="btn-limpar">Limpar</button>
                <button type="submit" class="btn-cadastrar">Finalizar Cadastro</button>
            </div>
        </form>
        <p style="text-align:center;"><a href="listas_users_fornecedores.php" style="color:#666; text-decoration:none; font-size:14px;">Voltar</a></p>
    </div>
</body>

</html>