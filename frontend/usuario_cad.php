<?php
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
    <title>Cadastro de Usuário - Integra Farma</title>
    <link rel="stylesheet" href="../css/cadastro_usuario.css">
</head>
<body>
    <div class="card">
        <h2>Criar Conta de Usuário</h2>
        <form action="../backend/usuario_cadastrar.php" method="POST">
            <input type="hidden" name="tipo_cadastro" value="usuario">
            
            <input type="text" name="nome" placeholder="Seu Nome Completo" required>
            <input type="text" name="login" placeholder="Escolha um nome de usuário (Login)" required>
            <input type="password" name="senha" placeholder="Crie uma Senha" required>
            
            <select name="nivel">
                <option value="admin">Administrador</option>
                <option value="funcionario">Funcionário</option>
            </select>
            
            <div class="botoes-form">
                <button type="reset" class="btn-limpar">Limpar</button>
                <button type="submit" class="btn-cadastrar">Finalizar Cadastro</button>
            </div>
        </form>
        <p style="text-align:center;"><a href="listas_users_fornecedores.php" style="color:#666; text-decoration:none; font-size:14px;">Cancelar e Voltar</a></p>
    </div>
</body>
</html>