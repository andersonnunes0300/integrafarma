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
            
            <button type="submit">Finalizar Cadastro</button>
        </form>
        <p style="text-align:center;"><a href="tela_login.php" style="color:#666; text-decoration:none; font-size:14px;">Voltar ao Login</a></p>
    </div>
</body>
</html>