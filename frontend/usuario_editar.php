<?php
session_start();
require_once '../conexao/conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if (!$usuario) {
        echo "<script>alert('Usuário não encontrado!'); window.location.href='tela_admin.php';</script>";
        exit;
    }
} else {
    header("Location: tela_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuário - Integra Farma</title>
    <link rel="stylesheet" href="../css/usuario_editar.css">
</head>

<body>
    <div class="card">
        <h2>Editar Usuário</h2>
        <form action="../backend/usuario_editar.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">

            <label class="form-label">Nome do Usuário:</label>
            <input class="form-control" type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>

            <label class="form-label">Usuário:</label>
            <input class="form-control" type="text" name="login" value="<?php echo htmlspecialchars($usuario['login']); ?>" required>

            <label class="form-label">Senha:</label>
            <input class="form-control" type="password" name="senha" placeholder="Nova senha" required>

            <label class="form-label">Nível de Acesso:</label>
            <select class="form-control" name="nivel_acesso" required>
                <?php
                echo "<option value='admin' " . ($usuario['nivel'] == 'admin' ? 'selected' : '') . ">Admin</option>";
                echo "<option value='funcionario' " . ($usuario['nivel'] == 'funcionario' ? 'selected' : '') . ">Funcionário</option>";
                ?>
                
            </select>

            <button type="submit" class="btn-save">Salvar Alterações</button>
            <a href="tela_admin.php" class="btn-cancel">Cancelar e Voltar</a>
        </form>
    </div>
</body>

</html>